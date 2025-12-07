<?php
header('Content-type: application/json');
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных
$id_user = $_COOKIE["user"];
$id = intval($_GET['id']);

$z = "SELECT `id`, `name`, `surname`, `photo_50`, `photo_100`, `sex` FROM users WHERE id={$id}";
$q = $mysqli->query($z);
if(!$q){exit(jout(err($mysqli->error, array("z" => $z))));}
$user_data = $r = $q->fetch_assoc();

$z = "
SELECT 
    COUNT(DISTINCT hm.id_hiking) AS count,
    MAX(h.start) AS first_start_date,
    MIN(h.finish) AS last_finish_date,
    GROUP_CONCAT(DISTINCT hm.id_hiking) AS hikings
FROM hiking_members hm
INNER JOIN hiking_members hm_filter ON hm.id_hiking = hm_filter.id_hiking
LEFT JOIN users u ON hm.id_user = u.id
LEFT JOIN hiking h ON hm.id_hiking = h.id
WHERE hm_filter.id_user = {$id_user}
  AND hm.id_user = {$id}
  AND u.id = {$id}
GROUP BY hm.id_user
";
$q = $mysqli->query($z);
if(!$q){exit(jout(err($mysqli->error, array("z" => $z))));}
if ($q->num_rows == 0 && $id != $id_user) {
    die(jout(err('Has no common hiking')));
}
$r = $q->fetch_assoc();

exit(jout(array(
    "user" => $user_data,
    "statistic" => $r,
)));