<?php
$id_track = intval($_GET['id_track']);
if (!($id_track > 0)) {
    die(json_encode(array('error' => 'id_track is required')));
}

include("../../../../blocks/db.php"); //подключение к БД
include("../../../../blocks/for_auth.php"); //Только для авторизованных

$id_user = intval($_COOKIE["user"]);

global $mysqli;

$z = "
SELECT
   *
FROM
    `hiking_tracks_break`
WHERE
    `id_track`={$id_track}
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = array(
        'id' => intval($r['id']),
        'is_break' => boolval($r['is_break']),
        'name' => $r['name'],
        'from' => array(
            'point' => array_map(function ($a) { return floatval($a); }, explode('|', $r['from_point'])),
            'time' => intval($r['from_time']),
        ),
        'to' => array(
            'point' => array_map(function ($a) { return floatval($a); }, explode('|', $r['to_point'])),
            'time' => intval($r['to_time']),
        ),
        'canEdit' => $id_user == intval($r['id_author'])
    );
}

exit(json_encode($res));
