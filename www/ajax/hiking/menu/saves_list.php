<?php
    include("../../../blocks/db.php"); //подключение к БД
    $id_hiking = intval($_GET['id_hiking']);

    $z = "
    SELECT
        hiking_menu_saves.id,
        hiking_menu_saves.name,
        hiking_menu_saves.date,
        hiking_menu_saves.confirm_user,
        hiking_menu_saves.confirm_date,
        CONCAT(users.name,' ', users.surname) AS user,
        is_current
    FROM
        `hiking_menu_saves`
    LEFT JOIN users ON users.id = hiking_menu_saves.id_author
    WHERE
        hiking_menu_saves.id_hiking = {$id_hiking}
    ORDER BY hiking_menu_saves.date DESC
    ";

    $q = $mysqli -> query($z);
    
    if(!$q) {
        die(json_encode(array('error' => $mysqli -> error)));
    }

    $result = array();

    while ($r = $q -> fetch_assoc()) {
        $result[] = $r;
    }

    die(json_encode($result));
