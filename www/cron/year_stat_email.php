<?php
include("../blocks/db.php"); //подключение к БД
require("../blocks/mail.php"); //мылилка


if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != getenv('MIGRATOR_USER') || $_SERVER['PHP_AUTH_PW'] != getenv('MIGRATOR_PASSWORD')) {
    header('WWW-Authenticate: Basic realm="Phodnik Migrator"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Без авторизации тут делать нечего';
    exit;
}

$year = date('Y');
$add_where = "";

if (isset($_GET['id_user'])) {
    $add_where = " AND users.id = ".intval($_GET['id_user']);
}


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
  YEAR(hiking_members.date) = '{$year}' {$add_where}
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
            Самую интересную мы собрали специально для тебя на <a href=\"{$url}\">странице персонализированной статистики</a>.</p>
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



    $result[] = array(
        "data" => $r,
        "subject" => $subject,
        "message" => $message,
        "result" => sendMail(
            array_map(function ($a) { global $r; return array($a, $r['name']." ".$r['surname']); }, explode(',', $r['addresses'])),
            $subject,
            $message,
            "",
            "Почтовый сервис сайта Походники"
        ),
        "error" => error_get_last()
    );
}


exit(json_encode($result));
