<?php
include("../blocks/db.php"); //подключение к БД

$year = date('Y');
$id_user = 3;
$z = "
SELECT 
  users.id,
  users.name,
  users.surname,
  users.sex,
  CONCAT_WS(',', users.email, user_subscribes.email) as addresses
FROM `hiking_members`
  LEFT JOIN users on hiking_members.id_user = users.id
  LEFT JOIN user_subscribes ON user_subscribes.id_user = users.id
WHERE
  YEAR(hiking_members.date) = '{$year}' AND
  users.id = {$id_user}
GROUP BY users.id
";

$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}
$result = array();
while ($r = $q -> fetch_assoc()) {
    $r['addresses'] = trim($r['addresses'], ',');

    $url = "https://pohodnik.tk/user/".$r['id']."/stat/{$year}";
    $subject = "Итоги походного сезона ".$year; 
    $obr = $r['sex']==2?'дорогая':'дорогой';
    $message = " 
    <html> 
        <head> 
            <title>Итоги походного сезона на сайте pohodnik.tk 🎄</title> 
        </head> 
        <body> 
            <p>Привет, ".$r['name'].".</p>
            <p>Если тебе пришло это письмо, значит ты достойно ".($r['sex']==2?'провела':'провел')." уходящий {$year}-й год.</p>
            <p>
            На сайте походников хранится много информации о походной жизни.
            Самую интересную мы собрали специально для тебя на <a href=\"{$url}\">странице персонализированой статистики</a>.</p>
            <p>Там ты увидишь много интересного. И Сможешь посмотреть каких успехов добились твои походные друзья :)</p>
            <br>
            <p>С наступающим новым годом! 🎅</p>
            <br>
            <p>-- <br>
            Почтовый сервис сайта Походники.<br>
            письмо сгенерировано автоматически
            </p>
        </body> 
    </html>"; 
    $to = $r['addresses'];
   // $headers = "From: Почтовый сервис сайта Походники <info@pohodnik.tk>\r\n";
    $headers = "Reply-To: info@pohodnik.tk\r\n";
    $headers .= "X-Mailer: pohodnik ".phpversion()."\r\n";
    $headers  .= "Content-type: text/html; charset=utf-8\r\n"; 
    


    $result[] = array(
        "data" => $r,
        "to" => $to,
        "subject" => $subject,
        "message" => $message,
        "headers" => $headers,
        "result" => mail($to, $subject, $message, $headers),
        "error" => error_get_last()['message']
    );
}


exit(json_encode($result));
