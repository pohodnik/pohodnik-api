<?php
include("../../blocks/db.php"); //подключение к БД
$lat = floatval($_GET['lat']);
$lon = floatval($_GET['lon']);
$dist = isset($_GET['dist']) ? intval($_GET['dist']) : 5;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;

$result = array();
$z ="
    SELECT 
    mountain_passes.`id`,
    mountain_passes.`name`,
    mountain_passes.`altitude`,
    mountain_passes.`id_pass_category`,
    mountain_passes.`comment`,
    mountain_passes.`description`,
    mountain_passes_categories.name AS category_name,
    mountain_passes_categories.description AS category_description,
    ST_Distance(Point({$lon}, {$lat}), mountain_passes.coordinates) AS distance,
    ST_X( mountain_passes.coordinates) as x,
    ST_Y( mountain_passes.coordinates) as y
    
    FROM
        `mountain_passes`
    LEFT JOIN mountain_passes_categories ON mountain_passes_categories.id = mountain_passes.id_pass_category
    WHERE
        1
    ORDER BY distance LIMIT {$limit}
";

    $q = $mysqli->query($z);
    if (!$q) {
        die(json_encode(array("error"=>$mysqli->error, "z" => $z))); 
    }


    while($r = $q->fetch_assoc()){
        $result[] = $r;
    }
    die( json_encode($result) );