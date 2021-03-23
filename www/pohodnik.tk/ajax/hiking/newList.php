<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/dates.php");
include("../../blocks/global.php");

$mode = isset($_GET['mode'])? $mysqli->real_escape_string($_GET['mode']) : 'current';
$type = isset($_GET['type'])? $mysqli->real_escape_string($_GET['type']) : 'my';

$limit = isset($_GET['limit'])? $mysqli->real_escape_string($_GET['limit']) : 10;
$offset = isset($_GET['offset'])? $mysqli->real_escape_string($_GET['offset']) : 0;

$startDate = isset($_GET['startDate'])? $mysqli->real_escape_string($_GET['startDate']) : null;
$endDate = isset($_GET['endDate'])? $mysqli->real_escape_string($_GET['endDate']) : null;

$types = isset($_GET['types'])? $mysqli->real_escape_string($_GET['types']) : array();
$regions = isset($_GET['regions'])? $mysqli->real_escape_string($_GET['regions']) : array();

$id_user = $_COOKIE["user"];
$claus = "1";
$joins = "";

if(isset($mode) && !empty($mode)) {
    switch($mode){
        case 'actual': // Актуальные походы
            $claus .= " AND hiking.start >= NOW() \r\n";
            break;
        case 'old': // Завершенные походы
            $claus .= " AND hiking.finish < NOW() \r\n";
            break;
    }
}

if(isset($type) && !empty($type)) {
    switch($type){
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

if(isset($_GET["actual"]) && $_GET["actual"]==1) {
    $claus .= " AND hiking.start>='".date('Y-m-d H:i:s')."' ";
}

if(isset($_GET["admin"]) && $_GET["admin"]==1){
    $claus .= " AND hiking.id_author={$id_user} ";
}

if(isset($startDate) && !empty($startDate)){
    $claus .= " AND (hiking.start >= '{$startDate}' OR hiking.finish >= '{$startDate}') ";
}

if(isset($endDate) && !empty($endDate)){
    $claus .= " AND (hiking.start <= '{$endDate}' OR hiking.finish <= '{$endDate}') ";
}

if(isset($types) && !empty($types)){
    $claus .= " AND hiking_types.id IN(".implode(",", $types).") ";
}

if(isset($regions) && !empty($regions)){
    $claus .= " AND hiking.id_region IN(".implode(",", $regions).") ";
}

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
        COUNT(all_members.id) AS members_count
    FROM `hiking`
        LEFT JOIN hiking_types ON hiking_types.id = hiking.id_type
        LEFT JOIN geo_regions ON geo_regions.id = hiking.id_region
        LEFT JOIN hiking_members AS all_members ON all_members.id_hiking = hiking.id
        {$joins}
    WHERE 
    	{$claus}
    GROUP BY hiking.id
    ORDER BY hiking.start DESC, hiking.id_type
    LIMIT ${offset}, ${limit}
";
$q = $mysqli->query($z);
if (!$q) { die(err($mysqli->error, array("q" => $z))); }


$qt = $mysqli->query("SELECT FOUND_ROWS();");
if (!$qt) { die(err($mysqli->error, array("q" => $z))); }

$total_count = $qt -> fetch_row()[0];

$result = array();

while($r = $q->fetch_assoc()){
    $r['start_date_rus'] = smartDate($r['start']);
    $r['finish_date_rus'] = smartDate($r['finish']);

    $r['duration'] = round((($r['finish']-$r['start'])/86400),1);


    $r['start_date'] = date('Y-m-d H:i:s', $r['start']);
    $r['finish_date'] = date('Y-m-d H:i:s',$r['finish']);

    $result[] = $r;
}


die(
out(
    array(
        "data" => $result,
        "totalCount" => $total_count
    )
)
);