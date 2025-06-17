<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/gpx.php"); //gps helpers
/** on python: https://gist.github.com/meyerjo/dd3533edc97c81258898f60d8978eddc */



ini_set('memory_limit', '256M');

global $mysqli;

$id1 = $_GET['id1'];
$id2 = $_GET['id2'];

$z = "
    SELECT `bounds` FROM `workout_tracks` WHERE id IN({$id1},{$id2})
";

$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = json_decode($r['bounds'], true);
    
}

exit(json_encode(array(
    "bounds1" => $res[0],
    "bounds2" => $res[1],
    "res" => compareBounds(array_merge(...$res[0]), array_merge(...$res[1]))
)));
