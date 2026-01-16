<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php");
include("../../blocks/global.php");

$result=array();

$where = "";

if (isset($_GET['id_user'])) {
    $where .= "AND hiking_radish.id_user=".intval($_GET['id_user']);
}

$q = $mysqli->query("
SELECT
    hiking_radish.id,
    hiking_radish.date,
    hiking_radish.comment,
    users.id as user_id,
    users.name as user_name,
    users.surname as user_surname,
    users.photo_50 AS user_photo,

    hiking.id as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,

    hiking_radish.killer = 0 as harakiri
FROM  `hiking_radish` 
    LEFT JOIN users ON hiking_radish.id_user = users.id
    LEFT JOIN hiking ON hiking.id = hiking_radish.id_hiking
WHERE 1 {$where}
ORDER BY hiking_radish.date
");
if(!$q){die(jout(err($mysqli->error)));}

while($r = $q->fetch_assoc()){
	$result[] = $r;
}

echo jout($result);
