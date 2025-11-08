<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/dates.php");
include("../../blocks/global.php");

$mode = isset($_GET['mode']) ? $mysqli->real_escape_string($_GET['mode']) : 'current';
$whose = isset($_GET['whose']) ? $mysqli->real_escape_string($_GET['whose']) : 'my';

$limit = isset($_GET['limit']) ? $mysqli->real_escape_string($_GET['limit']) : 10;
$offset = isset($_GET['offset']) ? $mysqli->real_escape_string($_GET['offset']) : 0;

$startDate = isset($_GET['d1']) ? $mysqli->real_escape_string($_GET['d1']) : null;
$endDate = isset($_GET['d2']) ? $mysqli->real_escape_string($_GET['d2']) : null;

$type = isset($_GET['type']) && !empty($_GET['type']) ? intval($_GET['type']) : null;
$region = isset($_GET['region']) && !empty($_GET['region']) ? intval($_GET['region']) : null;

$id_user = $_COOKIE["user"];
$claus = "1";
$joins = "";

if (isset($mode) && !empty($mode)) {
    switch ($mode) {
        case 'actual': // Актуальные походы
            $claus .= " AND hiking.start >= NOW() \r\n";
            break;
        case 'old': // Завершенные походы
            $claus .= " AND hiking.finish < NOW() \r\n";
            break;
    }
}

if (isset($whose) && !empty($whose)) {
    switch ($whose) {
        case 'my': // мои
            $joins .= " LEFT JOIN hiking_members ON hiking_members.id_hiking = hiking.id";
            $claus .= " AND hiking_members.id_user = {$id_user} \r\n";
            break;
        case 'all': // не мои
            $joins .= " LEFT JOIN hiking_members ON hiking_members.id_hiking = hiking.id AND hiking_members.id_user = {$id_user}";
            $claus .= " AND hiking_members.id_user IS NULL \r\n";
            break;
    }
}

if (isset($_GET["actual"]) && $_GET["actual"] == 1) {
    $claus .= " AND hiking.start>='" . date('Y-m-d H:i:s') . "' ";
}

if (isset($_GET["admin"]) && $_GET["admin"] == 1) {
    $claus .= " AND hiking.id_author={$id_user} ";
}

if (isset($startDate) && !empty($startDate)) {
    $claus .= " AND hiking.start >= '{$startDate}' ";
}

if (isset($endDate) && !empty($endDate)) {
    $claus .= " AND hiking.finish <= '{$endDate}' ";
}

if (isset($type) && !empty($type)) {
    $claus .= " AND hiking_types.id = {$type}";
}

if (isset($region) && !empty($region)) {
    $claus .= " AND hiking.id_region = {$region} ";
}
$q = $mysqli->query("SET SESSION group_concat_max_len=999999;");
$z = "
   SELECT SQL_CALC_FOUND_ROWS
        hiking.id, 
        hiking.id_type, 
        hiking.name, 
        hiking.ava, 
        hiking.`desc`, 
        hiking.id_route,
        geo_regions.name AS region_name,
        hiking.id_author AS iauthor,
        UNIX_TIMESTAMP(hiking.start) AS start, 
        UNIX_TIMESTAMP(hiking.finish) AS finish,
        hiking_types.name AS type,
        COUNT(all_members.id) AS members_count,
      
        (SELECT
            GROUP_CONCAT(
                CONCAT_WS(
                    '¶',
                    users.id,
                    users.name,
                    users.surname,
                    users.photo_50
                )
                SEPARATOR '§'
            )
        FROM
            users
                LEFT JOIN hiking_members
                    ON hiking_members.id_user=users.id
        WHERE
            hiking_members.id_hiking=hiking.id
        )  as members_list,
        (
            SELECT
                SUM(distance)
            FROM
                workout_tracks
            LEFT JOIN hiking_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
            WHERE
                hiking_tracks.id_hiking = hiking.id
        ) as distance,
        (
            SELECT
                SUM(distance)
            FROM
                `route_objects`
            WHERE
                route_objects.id_route = hiking.id_route AND route_objects.`id_typeobject`=2
        ) as plan_distance
    FROM `hiking`
        LEFT JOIN hiking_types ON hiking_types.id = hiking.id_type
        LEFT JOIN geo_regions ON geo_regions.id = hiking.id_region
        LEFT JOIN hiking_members AS all_members ON all_members.id_hiking = hiking.id
        
        
        {$joins}
    WHERE 
    	{$claus}
    GROUP BY hiking.id
    ORDER BY hiking.start DESC, hiking.id_type
    LIMIT {$offset}, {$limit}
";
$q = $mysqli->query($z);
if (!$q) {
    die(err($mysqli->error, array("q" => $z)));
}


$qt = $mysqli->query("SELECT FOUND_ROWS();");
if (!$qt) {
    die(err($mysqli->error, array("q" => $z)));
}

$total_count = $qt->fetch_row()[0];

$result = array();

while ($r = $q->fetch_assoc()) {
    $r['start_date_rus'] = smartDate($r['start']);
    $r['finish_date_rus'] = smartDate($r['finish']);

    $r['duration'] = round((($r['finish'] - $r['start']) / 86400), 1);

    $r['start_date'] = date('Y-m-d H:i:s', $r['start']);
    $r['finish_date'] = date('Y-m-d H:i:s', $r['finish']);

    $result[] = $r;
}


die(out(
    array(
        "data" => $result,
        "totalCount" => $total_count
    )
));
