<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");
$result = array();
$current_user = intval($_COOKIE["user"]);



$z = "SELECT 
    workout_tags.id,
    workout_tags.name,
    workout_tags.color,
    workout_tags.is_personal,
    workout_tags.created_at,
    workout_tags.creator_id
FROM workout_tags
WHERE workout_tags.is_personal = 0 OR workout_tags.creator_id = {$current_user}
";
$q = $mysqli->query($z);
if (!$q) {
    die(err($mysqli->error, array("z" => $z)));
}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}


die(out($res));
