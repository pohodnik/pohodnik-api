<?php
    include("../blocks/db.php"); //подключение к БД
    $date = isset($_GET['date']) ? "'".$_GET['date']."'": 'NOW()';

    $z = "SELECT `id`, `name`, `start`, `finish`, {$date} as today FROM `hiking`
          WHERE (DATE({$date}) BETWEEN DATE(`start`) AND DATE(`finish`))";
    $q = $mysqli->query($z);
    //die($z);
    if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error, "z" => $z)));}

    $hiking_day_info_map = array();

    while($r = $q->fetch_assoc()){
        $hiking_id = $r['id'];
        $hiking_name = $r['name'];
        $hiking_start = $r['start'];
        $hiking_finish = $r['finish'];
        $today = $r['today'];

        $hiking_day_info_map[$hiking_id] = array();

        $hiking_day_info_map[$hiking_id][] = "Информация по походу «{$hiking_name}»";
        $days_passed = ceil((strtotime($today) - strtotime($hiking_start)) / (60 * 60 * 24)) + 1;
        $days_left = ceil((strtotime($hiking_finish) - strtotime($hiking_start)) / (60 * 60 * 24)) + 1;
        $hiking_day_info_map[$hiking_id][] = "Сегодня {$days_passed} из {$days_left} день похода";
    }

    print_r($hiking_day_info_map);
?>
