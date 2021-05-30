<?php
    include("../../../blocks/db.php"); //подключение к БД
    $id = intval($_POST['id']);

    $z = "
        DELETE FROM hiking_menu_saves WHERE id = {$id}
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('error' => $mysqli -> error)));
    }

    die(json_encode(array('success' => true)));