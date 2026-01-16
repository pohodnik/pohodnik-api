<?php
    include("../../../blocks/db.php"); //подключение к БД
    $id = intval($_POST['id']);

    $id_user = intval($_COOKIE["user"]);

    $result = array();

    $z = "
    SELECT
        `data`,
        `data_products`,
        `data_products_replaces`,
        `id_hiking`
    FROM
        `hiking_menu_saves`
    WHERE
        id = {$id}
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('error' => $mysqli -> error)));
    }

    if($q -> num_rows === 0) {
        die(json_encode(array('error' => 'not found', 'z' => $z)));
    }

    $res = $q -> fetch_assoc();

    $data = $res['data'];
    $data_products = $res['data_products'];
    $data_products_replaces = $res['data_products_replaces'];
    $id_hiking = $res['id_hiking'];

    if (strlen($data) > 1) {
        $dataGroups = explode(',', $data);
        if (count($dataGroups) > 0) {
            $q1 = $mysqli -> query("UPDATE `hiking_menu` SET assignee_user = NULL WHERE id_hiking = {$id_hiking}");
            if(!$q1) { die(json_encode(array('in' => 'q1', 'error' => $mysqli -> error))); }

            $updates = array();
            
            foreach ($dataGroups as $idValStr) {
                $idVal = explode(':', $idValStr);
                $updates[] = "UPDATE `hiking_menu` SET assignee_user = {$idVal[1]} WHERE id = {$idVal[0]} AND id_hiking = {$id_hiking}";
            }

            $sql = implode(";\r\n", $updates);
            $q2 = $mysqli->multi_query($sql);
            if(!$q2) { die(json_encode(array('in' => 'q2', 'error' => $mysqli -> error))); }

            $result['hiking_menu'] = $mysqli -> affected_rows;
        } else {  $result['hiking_menu'] = 'no data split'; }
    } else {
        $result['hiking_menu'] = 'no data length';
        $result['hiking_menu_data'] = $data;
    }

    clearStoredResults();

    
    if (strlen($data_products) > 1) {
        $dataProducts = explode(',', $data_products);
        if (count($dataProducts) > 0 && strlen($dataProducts[0] > 0)) {

            $q3 = $mysqli -> multi_query("DELETE FROM `hiking_menu_products_force` WHERE id_hiking = {$id_hiking};");
            if(!$q3) { die(json_encode(array('in' => 'q3', 'error' => $mysqli -> error))); }

            $inserts = array();
            
            foreach ($dataProducts as $idValStr) {
                $idVal = explode(':', $idValStr); 
                if ($idVal[0] > 0 && $idVal[1] > 0) {
                    $inserts[] = "({$id_hiking},{$idVal[0]},{$idVal[1]},NOW(),{$id_user})";
                }
            }

            $sql = "INSERT INTO `hiking_menu_products_force`(`id_hiking`, `id_user`, `id_product`, `date`, `id_author`) VALUES ".implode(",\r\n", $inserts);
            $q4 = $mysqli->multi_query($sql);
            if(!$q4) { die(json_encode(array('in' => 'q4', 'error' => $mysqli -> error, 'sql' => $sql))); }

            $result['hiking_menu_products_force'] = $mysqli -> affected_rows;
        }
    }

    clearStoredResults();

    if (strlen($data_products_replaces) > 1) {
        $dataProductsReplaces = explode(',', $data_products_replaces);
        if (count($dataProductsReplaces) > 0 && strlen($dataProductsReplaces[0]) > 0) {

            $q3 = $mysqli -> multi_query("DELETE FROM `hiking_menu_products_replace` WHERE id_hiking = {$id_hiking};");
            if(!$q3) { die(json_encode(array('in' => 'q77', 'error' => $mysqli -> error))); }

            $inserts = array();
            
            foreach ($dataProductsReplaces as $idValStr) {
                $idVal = explode(':', $idValStr); 
                if ($idVal[0] > 0 && $idVal[1] > 0 && $idVal[2] > 0) {
                    $inserts[] = "({$id_hiking},{$idVal[0]},{$idVal[1]},{$idVal[2]},'{$idVal[3]}',NOW(),{$id_user})";
                }
            }

            $sql = "INSERT INTO `hiking_menu_products_replace`(`id_hiking`, `id_source_product`, `id_target_product`, `rate`, `comment`, `created_at`, `creator_id`) VALUES ".implode(",\r\n", $inserts);
            $q4 = $mysqli->multi_query($sql);
            if(!$q4) { die(json_encode(array('in' => 'q77', 'error' => $mysqli -> error, 'sql' => $sql))); }

            $result['hiking_menu_products_replace'] = $mysqli -> affected_rows;
        }
    }

    clearStoredResults();

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
        die(json_encode(array('in' => 'q5', 'error' => $mysqli -> error)));
    }

    $z = "
    UPDATE
        `hiking_menu_saves`
    SET
        is_current = 1
    WHERE
        id_hiking = {$id_hiking} AND id = {$id}
    ";

    $q6 = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('in' => 'q6', 'error' => $mysqli -> error)));
    }

    $result['success'] = true;

    die(json_encode($result));
