<?php
ini_set('memory_limit', '512M');
include("../blocks/db.php"); //подключение к БД

$open_weather_api_key = getenv('OPENWEATHER_API_KEY');
if (empty($open_weather_api_key)) { die(json_encode(array('error' => "Has no OPENWEATHER_API_KEY variable"))); }

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
            date = DATE(DATE_ADD(NOW(), INTERVAL 2 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 3 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 4 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 5 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 6 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 7 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 8 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 9 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 10 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 11 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 12 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 13 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 14 DAY)) OR
            date = DATE(DATE_ADD(NOW(), INTERVAL 15 DAY))
        ) {$add_where}
";

$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
if($q -> num_rows == 0){exit(json_encode(array("error"=>"No Data")));}
$res = array();
$updateQueries = array();

while ($r = $q -> fetch_assoc()) {
    extract($r);
    $url = "https://api.openweathermap.org/data/2.5/forecast?units=metric&lat={$lat}&lon={$lon}&APPID={$open_weather_api_key}&lang=ru";
    $body = file_get_contents($url);
    $weather = json_decode($body, true);

    if (is_array($weather['list'])) {
        $datesForecast = array();

        foreach ($weather['list'] as $hour) {
            $utc_date = date('Y-m-d', $hour['dt']);
            if (!isset($datesForecast)) {
                $datesForecast[$utc_date] = array();
            }
            $datesForecast[$utc_date][] = $hour;
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
