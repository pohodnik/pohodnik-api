<?php
include("../../blocks/db.php"); //подключение к БД
$q = $mysqli->real_escape_string($_GET['q']);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;

$result = array();
    $q = $mysqli->query("
    SELECT
        mountain_passes.`id`,
        mountain_passes.`name`,
        mountain_passes.`altitude`,
        mountain_passes.`id_pass_category`,
        mountain_passes.`comment`,
        mountain_passes.`description`,
        mountain_passes_categories.name AS category_name,
        mountain_passes_categories.description AS category_description
    FROM
        `mountain_passes`
    LEFT JOIN mountain_passes_categories ON mountain_passes_categories.id = mountain_passes.id_pass_category
    WHERE
        mountain_passes.`name` LIKE('%{$q}%') OR mountain_passes.`comment` LIKE('%{$q}%') OR mountain_passes.`description` LIKE('%{$q}}%')
    LIMIT {$limit}
    ");
    if (!$q) {
        die(json_encode(array("error"=>"Ошибка при получении данных. \r\n".$mysqli->error))); 
    }


    while($r = $q->fetch_assoc()){
        $result[] = $r;
    }
    die( json_encode($result) );