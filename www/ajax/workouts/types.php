<?php
include("../../blocks/db.php"); //подключение к БД

global $mysqli;

$z = "
    SELECT `id`, `name` FROM `workout_types` WHERE 1
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

exit(json_encode($res));
