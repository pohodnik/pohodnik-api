<?php
	require("../../../blocks/mail.php");
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php"); //Только для авторизованных
	include("../../../blocks/global.php");
	include("../../../blocks/err.php");

	$id_user = intval($_COOKIE["user"]);
	$id = intval($_POST['id']);

	$q = $mysqli->query("
      SELECT
        user_subscribes.`id`,
        user_subscribes.`id_user`,
        user_subscribes.`email`,
        user_subscribes.`confirm_code`,
        UNIX_TIMESTAMP(`confirm_date`) AS uts,
        users.name as user_name,
        users.surname as user_surname,
        users.photo_50 as user_photo,
        users.sex as user_sex

      FROM `user_subscribes`
        LEFT JOIN users on users.id = user_subscribes.id_user
      WHERE user_subscribes.id_user={$id_user} AND user_subscribes.id={$id}
      LIMIT 1
    ");

	if(!$q){die(err($mysqli->error));}
	$r = $q->fetch_assoc();


    $domain = "pohodnik.tk";

	$url = "https://{$domain}/confirm-email/" . $r['confirm_code'];
	$subject = "Проверка рассылки на сайте {$domain}"; 
	$obr = $r['user_sex']==2?'дорогая':'дорогой';
	$message = " 
	<html> 
	    <head> 
	        <title>Проверка рассылки на сайте {$domain}</title> 
	    </head> 
	    <body> 
	        <p>Здравствуй, {$obr} ".$r['user_name'].".</p>
	        <p>Это письмо сформировано в рамках проверки рассылки на сайте {$domain}.</p>
            <img src=\"{$r['user_photo']}\" alt=\"{$r['user_name']}\">
            <p>
            Настроить рассылки можно в <a href=\"https://{$domain}/profile#subscribes\">личном кабинете</a>
            </p>
	        <p>-- <br>
	        Почтовый сервис сайта Походники Пензы.<br>
	        <small>
                Отписаться от рассылки можно в <a href=\"https://{$domain}/profile#subscribes\">личном кабинете</a>
            </small>
	        </p> 
	    </body> 
	</html>"; 
	$to = array(
        array(
            $r['email'],
            $r['user_name']." ".$r['user_surname']
        )
    );


die(jout(array(
    "result" => sendMail(
        $to,
        $subject,
        $message,
        "",
        "Почтовый сервис сайта Походники"
    )
)));
?>