<?php
    include("../../../blocks/db.php"); //подключение к БД
    $id = intval($_POST['id']);
    $name = $mysqli -> real_escape_string(trim($_POST['name']));

    $id_user = $_COOKIE["user"];

    $z = "
    UPDATE
        `hiking_menu_saves`
    SET
        `name` = '{$name}'
    WHERE
        `id` = {$id}
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('error' => $mysqli -> error, "z" => $z)));
    }

    die(json_encode(array('success' => true)));
