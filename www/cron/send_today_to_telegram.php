<?php
	// ini_set('error_reporting', E_ALL);
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
    include("../blocks/db.php"); //подключение к БД
    $date = isset($_GET['date']) ? "'".$_GET['date']."'": 'NOW()';

    $weather_emoji = array(
        '01d' => '☀️',
        '02d' => '🌤️',
        '03d' => '☁️',
        '04d' => '☁️☁️',
        '09d' => '🌧️',
        '10d' => '🌦️',
        '11d' => '🌩️',
        '13d' => '❄️',
        '50d' => '🌫️',
        '01n' => '☀️',
        '02n' => '🌤️',
        '03n' => '☁️',
        '04n' => '☁️☁️',
        '09n' => '🌧️',
        '10n' => '🌦️',
        '11n' => '🌩️',
        '13n' => '❄️',
        '50n' => '🌫️',
        '11d' => '⚡',
        '09d' => '💦'
    );

    function degToCard($value) {
        $value = intval($value);
        if ($value <= 11.25) return 'N';
        $value -= 11.25;
        $allDirections = array('NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
        $dIndex = intval($value/22.5);
        return isset($allDirections[$dIndex]) ? $allDirections[$dIndex] : 'N';
    }
    

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
    
        $weather_query = "SELECT
            `name`, `city`, `lat`, `lon`, `forecast`, `hourly_forecast`, `created_at`
        FROM `hiking_weather` WHERE `id_hiking`={$hiking_id} AND DATE(`date`)=DATE({$date})";
        $weather_query_result = $mysqli->query($weather_query);
        if(!$weather_query_result){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error, "weather_query" => $weather_query)));}

        $weather = $weather_query_result -> fetch_assoc();
        extract($weather);

        $hiking_day_info_map[$hiking_id][] = "Прогноз погоды получен для точки «{$name}» ({$created_at})";

        $hourly = json_decode($hourly_forecast, true);
        $forecast = json_decode($forecast, true);
        $city = json_decode($city, true);

        $hiking_day_info_map[$hiking_id][] = 'Восход: '.gmdate('H:m:i', $forecast['sunrise'] + $city['timezone']).' местн. Закат: '.gmdate('H:m:i',$forecast['sunset'] + $city['timezone']).' местн.';

        foreach ($hourly as $h) {


            $t = round($h['main']['temp'],0);
    
            $wmin = round($h['wind']['speed'], 0);
            $wmax = round($h['wind']['gust'],0);
            $wdir = degToCard($h['wind']['deg']);
            $wsp = $wmin == $wmax ? $wmax : "{$wmin}-{$wmax}";
    
            $osCou =  isset($h['snow'])
                ? round($h['snow']['3h'],1)
                : round($h['rain']['3h'],1);
    
            $os =  $osCou > 0 && $h['pop'] > 0
                ? (isset($h['snow'])?'s':'r').($osCou*10)."x".round($h['pop'] * 10,0)
                : "";
            $hiking_day_info_map[$hiking_id][] = gmdate('H:m:i', $h['dt'] + $city['timezone'])." {$t}℃ {$os}";
        }
    

    }
echo '<pre>';
    print_r($hiking_day_info_map);
?>
