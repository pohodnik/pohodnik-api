<?php
header('Content-type: application/json');
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных

$id_user = $_COOKIE["user"];
$z = "SELECT  
    COUNT(DISTINCT hm.id_hiking) AS hiking_count,
    MIN(h.start) AS hiking_first_date,
    MAX(h.finish) AS hiking_last_date,
    GROUP_CONCAT(DISTINCT hm.id_hiking) AS hiking_ids,
    u.id,
    u.name,
    u.surname,
    u.photo_50,
    u.sex,
    u.photo_100
FROM hiking_members hm
INNER JOIN hiking_members hm2 ON hm.id_hiking = hm2.id_hiking
LEFT JOIN users u ON hm.id_user = u.id
LEFT JOIN hiking h ON hm.id_hiking = h.id
WHERE hm2.id_user = {$id_user}
  AND hm.id_user <> {$id_user}
GROUP BY u.id, u.name, u.surname, u.vk_id, u.photo_50, u.sex
ORDER BY hiking_count DESC, hiking_last_date";

$q = $mysqli->query($z);
if (!$q) die(jout(err($mysqli->error, array("z"=>$z))));

$result = array();

while($r = $q->fetch_assoc()){
  $result[] = array(
    "user" => array(
        "id" => $r['id'],
        "name" => $r['name'],
        "surname" => $r['surname'],
        "photo_50" => $r['photo_50'],
        "photo_100" => $r['photo_100'],
        "sex" => $r['sex'],
    ),
    "statistic" => array(
        "count" => $r['hiking_count'],
        "first_start_date" => $r['hiking_first_date'],
        "last_finish_date" => $r['hiking_last_date'],
        "hikings" => $r['hiking_ids'],
    ),
  );
}
exit(jout($result));

?>