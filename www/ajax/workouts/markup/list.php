<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);

$add_where = "";

if (isset($_GET['id_workout_track'])) {
    $add_where .= " AND workout_track_markup.`id_workout_track` = ".intval($_GET['id_workout_track']);
}

$z = "SELECT 
    workout_track_markup.`id`,
    workout_track_markup.`id_workout_track`,
    workout_track_markup.`name`,
    workout_track_markup.`is_break`,
    workout_track_markup.`date_from`,
    workout_track_markup.`date_to`,
    workout_track_markup.`created_at`,
    workout_track_markup.`updated_at`,
    workout_track_markup.`id_author`,
    users.id as author_id,
    users.name as author_name,
    users.surname as author_surname,
    users.photo_50 as author_photo
FROM
  `workout_track_markup`
  LEFT JOIN users ON users.id = workout_track_markup.`id_author`
WHERE 1 {$add_where}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}
die(out($res));