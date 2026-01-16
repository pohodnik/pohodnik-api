<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php");

$result = array();
$id_user = intval($_COOKIE["user"]);
$id = intval($_GET['id']);

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
   iv.id={$id}
";
$q = $mysqli->query($z);
if (!$q) die(jout(err($mysqli->error)));

$r = $q->fetch_assoc();

exit(jout($r));
