<?php
header('Content-type: application/json');
require_once("../../blocks/err.php"); //подключение к БД
include("../../blocks/db.php"); //подключение к БД
require_once '../../blocks/global.php';

$q = $mysqli->query("
        SELECT 
            hiking.id, 
            hiking.name, 
            hiking.ava,
            hiking.start, 
            hiking.finish,
            hiking.id_type, 
            hiking_types.name AS type
        FROM `hiking`
            LEFT JOIN hiking_types ON hiking_types.id = hiking.id_type
        WHERE hiking.finish > NOW()
        ORDER BY hiking.start, hiking.id_type
    ");



if ($q) {
    $result = array();
    while ($r = $q->fetch_assoc()) {
        $result[] = $r;
    }

    die(jout($result));
} else {
    exit(err("Не могу получить список походов \r\n" . $mysqli->error));
}
