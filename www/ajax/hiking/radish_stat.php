<?php
include("../../blocks/db.php"); //подключение к БД
$result=array(); $id_user = intval($_COOKIE["user"]);
$q = $mysqli->query("SELECT 
    users.id as user_id,
    users.name as user_name,
    users.surname as user_surname,
    users.photo_100 AS user_photo,
    COUNT( hiking_radish.id ) AS cou,
    MAX( hiking_radish.date ) AS max_date
FROM  `hiking_radish` 
LEFT JOIN users ON hiking_radish.id_user = users.id
GROUP BY hiking_radish.id_user
ORDER BY cou DESC, max_date DESC
");
if(!$q){die($mysqli->error);}
$result['users']= array();
$user_ids = array();

while($r = $q->fetch_assoc()){
    $user_ids[] = $r['user_id'];
	$result['users'][] = $r;
}

$q = $mysqli->query("SELECT id_user, COUNT(id) as cou FROM `hiking_members` WHERE id_user IN(".implode(',', $user_ids).") GROUP BY id_user");
$result['hikingCounts'] = array();
while($r = $q->fetch_assoc()){
    $result['hikingCounts'][$r['id_user']] = intval($r['cou']);
}


$q = $mysqli->query("SELECT DISTINCT comment FROM `hiking_radish`");
$result['comments']= array();
while($r = $q->fetch_row()){
$result['comments'][] = $r[0];
}

echo json_encode($result);
