<?php
include("../../blocks/for_auth.php");
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/global.php");

$result=array();

$id_hiking = intval($_GET['id_hiking']);

if (!($id_hiking>0)) die(jout(err('id_hiking is required')));

$q = $mysqli->query("
SELECT
    hiking_radish.id,
    hiking_radish.date,
    hiking_radish.comment,
    users.id as user_id,
    users.name as user_name,
    users.surname as user_surname,
    users.photo_50 AS user_photo,
    hiking_radish.killer = 0 as harakiri
FROM  `hiking_radish` 
    LEFT JOIN users ON hiking_radish.id_user = users.id
WHERE hiking_radish.id_hiking={$id_hiking}
ORDER BY hiking_radish.date
");
if(!$q){die(jout(err($mysqli->error)));}

while($r = $q->fetch_assoc()){
	$result[] = $r;
}

echo jout($result);