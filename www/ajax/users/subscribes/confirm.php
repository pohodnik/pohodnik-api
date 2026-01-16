<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	include("../../../blocks/global.php");

	$id_user = intval($_COOKIE["user"]);
	$id = intval($_POST['id']);

	$q = $mysqli->query("
      SELECT `id`, `id_user`, `email`,`confirm_code`, UNIX_TIMESTAMP(`confirm_date`) AS uts
      FROM `user_subscribes`
      WHERE id_user={$id_user} AND id={$id}
      LIMIT 1
    ");

	if(!$q){die(err($mysqli->error));}
	$r = $q->fetch_assoc();
	if($r['uts']>0){
        die(err("Рассылка уже подтверждена"));
    }


	$qu = $mysqli->query("SELECT name, surname, sex FROM users WHERE id={$id_user} LIMIT 1");
	if(!$qu){die(err($mysqli->error));}
	$user = $qu->fetch_assoc();

    $domain = "pohodnik.tk";

	$url = "https://{$domain}/confirm-email/" . $r['confirm_code'];
	$subject = "Подтвердите адрес электронной почты на сайте {$domain}"; 
	$obr = $user['sex']==2?'дорогая':'дорогой';
	$message = " 
	<html> 
	    <head> 
	        <title>Подтвердите адрес электронной почты на сайте {$domain}</title> 
	    </head> 
	    <body> 
	        <p>Здравствуй, {$obr} ".$user['name'].".</p>
	        <p>Для получения рассылок тебе необходимо подтвердить адрес электронной почты.</p>
	        <p>Для этого нужно перейти по ссылке 
              <div style=\"padding:12px 24px; background:#f8f8f8\">
                <a href=\"{$url}\">{$url}</a>
              </div>
            </p>
	        <p>-- <br>
	        Почтовый сервис сайта Походники Пензы.<br>
	        <small>
                Отписаться от рассылки можно в <a href=\"https://{$domain}/profile#subscribes\">личном кабинете</a>
            </small>
	        </p> 
	    </body> 
	</html>"; 
	$to = $user['name']." ".$user['surname']." <".$r['email'].">";
	$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
	$headers .= "From: Походник <info@pohodnik58.ru>\r\n";

    die(json_encode(array("success"=>mail($to, $subject, $message, $headers))));
?>
