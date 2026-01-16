<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php");

$result = array();
$id_user = intval($_COOKIE["user"]);
$add_where = "";

if (isset($_GET['id_hiking'])) {
    $add_where .= " AND iv.`id_hiking`=".intval($_GET['id_hiking']);
}

$z = "SELECT
    `iv`.`id`,
    `iv`.`name`,
    `iv`.`desc`,
    `iv`.`id_author`,
    `iv`.`date_start`,
    `iv`.`date_finish`,
    `iv`.`hello_text`,
    `iv`.`by_text`,
    `iv`.`members_limit`,
    `iv`.`id_hiking`,
    `iv`.`main`,
    
    hiking.id as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,

    iv.id_author as user_id,
	users.surname as user_surname,
    users.name as user_name,
	users.photo_50 as user_photo
FROM
    `iv`
    LEFT JOIN hiking ON hiking.id = iv.`id_hiking`
    LEFT JOIN users ON users.id =iv.id_author
WHERE
1 {$add_where}
    ORDER BY `iv`.`date_start` DESC
";
$q = $mysqli->query($z);
if (!$q) die(jout(err($mysqli->error)));

while($r = $q->fetch_assoc()){
    $result[] = $r;
}    

exit(jout($result));