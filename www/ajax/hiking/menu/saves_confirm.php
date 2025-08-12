<?php
    include("../../../blocks/db.php"); //подключение к БД

    include("../../../blocks/rules.php"); // Права доступа

    global $mysqli;

    $current_user = $_COOKIE["user"];
    $date = 'NOW()';

    $id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

    if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}

    $hasBossRules = hasHikingRules($id_hiking, array('boss'));
    if (!$hasBossRules) { die(json_encode(array("error"=>"Доступно только руководителю"))); }

    $id = intval($_POST['id']);
    $confirm = $mysqli->real_escape_string($_POST['confirm']);

    if ($confirm == 'false') {
        $current_user = 'NULL';
        $date = 'NULL';
    }


    $z = "
    UPDATE
        `hiking_menu_saves`
    SET
        `confirm_date` = {$date},
        `confirm_user` = {$current_user}
    WHERE
        `id` = {$id}
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('error' => $mysqli -> error, "z" => $z)));
    }

    die(json_encode(array('success' => true, 'date' => $date)));
