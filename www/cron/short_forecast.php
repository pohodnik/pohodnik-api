<?php
ini_set('memory_limit', '512M');
include("../blocks/db.php"); //подключение к БД

$add_where = "";

if (isset($_GET['id_hiking'])) {
    $add_where .= " AND `id_hiking`=".intval($_GET['id_hiking']);
}

$z = "SELECT
        `id`,
        `id_hiking`,
        `date`,
        `name`,
        `lat`,
        `lon`,
        `forecast`,
        `created_at`
    FROM
        `hiking_weather`
    WHERE
        (
            date = DATE(NOW()) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 1 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 2 DAY))
        ) {$add_where}
";

$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
if($q -> num_rows == 0){exit(json_encode(array("error"=>"No Data")));}
$res = array();
$updateQueries = array();

while ($r = $q -> fetch_assoc()) {
    extract($r);
    $url = "http://api.openweathermap.org/data/2.5/onecall?exclude=current,minutely,daily,alerts&units=metric&lat={$lat}&lon={$lon}&APPID=2c7ee5aa0cd9ccedbcb6c836b605c24c&lang=ru";
    $body = file_get_contents($url);
    $weather = json_decode($body, true);
    $timezone_offset = $weather['timezone_offset'];

        if (is_array($weather['hourly'])) {
                $oneweather = $weather['hourly'];
                $datesForecast = array();

                foreach ($weather['hourly'] as $hour) {
                    $t = date('Y-m-d', ($hour['dt'] + $timezone_offset) - 1);
                    if (!isset($datesForecast)) {
                        $datesForecast[$t] = array();
                    }
                    $hour['dt'] = $hour['dt'] + $timezone_offset;
                    $hour['time'] = date('H', $hour['dt']);

                    $datesForecast[$t][] = $hour;
                }

                foreach ($datesForecast as $isoDate => $hourlyForecasts) {
                    $forecastStr = json_encode($hourlyForecasts, JSON_UNESCAPED_UNICODE);
                    $updateQueries[] =  "UPDATE
                        hiking_weather SET hourly_forecast = '{$forecastStr}', created_at = NOW()
                    WHERE date='{$isoDate}' AND id_hiking={$id_hiking}";
                }
        } else {
            die(json_encode(array(
                'error' => 'not array',
                'weather' => $weather
            )));
        }
    }


    $q = $mysqli->multi_query(implode(";", $updateQueries));
    if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error, '$updateQueries' => $updateQueries)));}

    clearStoredResults();

    die(json_encode(array(
        'up' => $updateQueries,
        'res' => $weather
    )));
?>
