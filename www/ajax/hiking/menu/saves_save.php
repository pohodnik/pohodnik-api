<?php
    include("../../../blocks/db.php"); //подключение к БД
    
    $id_hiking = intval($_POST['id_hiking']);
    $name = $mysqli -> real_escape_string(trim($_POST['name']));

    $id_user = $_COOKIE["user"];

    $z = "SELECT GROUP_CONCAT(CONCAT_WS(':', id, assignee_user)) FROM `hiking_menu` WHERE id_hiking = {$id_hiking} AND assignee_user IS NOT NULL";
    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('in' => 'hiking menu', 'error' => $mysqli -> error)));
    }

    $r = $q -> fetch_row();
    $data = $r[0];

    $z = "SELECT GROUP_CONCAT(CONCAT_WS(':', id_user, id_product)) FROM `hiking_menu_products_force` WHERE id_hiking = {$id_hiking}";
    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('in' => 'product forces', 'error' => $mysqli -> error)));
    }

    $r = $q -> fetch_row();
    $data_products = $r[0];

    $z = "
    UPDATE
        `hiking_menu_saves`
    SET
        is_current = 0
    WHERE
        id_hiking = {$id_hiking}
    ";

    $q5 = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('in' => 'reset currents', 'error' => $mysqli -> error)));
    }
   
    $z = "
    INSERT INTO
        `hiking_menu_saves`
    SET
        `name` = '{$name}',
        `id_hiking` = {$id_hiking},
        `data` = '{$data}',
        `data_products` = '{$data_products}',
        `id_author` = {$id_user},
        `date` = NOW(),
        `is_current` = 1
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('in' => 'main', 'error' => $mysqli -> error)));
    }

    die(json_encode(array('success' => true, 'id' => $mysqli -> insert_id)));
