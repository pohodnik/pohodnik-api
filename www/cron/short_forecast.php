<?php
ini_set('memory_limit', '512M');
include("../blocks/db.php"); //подключение к БД
$current_user = $_COOKIE["user"];

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
        (date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY)) {$add_where}
";

$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
$res = array();
$updateQueries = array();
if ($q -> num_rows > 0) {
    

    while ($r = $q -> fetch_assoc()) {
        extract($r);

        $url = "http://api.openweathermap.org/data/2.5/onecall?exclude=current,minutely,daily,alerts&units=metric&lat={$lat}&lon={$lon}&APPID=2c7ee5aa0cd9ccedbcb6c836b605c24c&lang=ru";
        $body = file_get_contents($url);

        $weather = json_decode($body, true);

        if (is_array($weather['hourly'])) {
                $oneweather = $weather['hourly'];
                $forecastObj = json_decode($forecast, true);
                $forecastObj['hourly'] = $oneweather;
                $forecastStr = json_encode($forecastObj, JSON_UNESCAPED_UNICODE);
                $updateQueries[] =  "UPDATE hiking_weather SET forecast = '{$forecastStr}', created_at = NOW() WHERE id='{$id}'";
        } else {
            die(json_encode(array(
                'error' => 'not array',
                'weather' => $weather
            )));
        }
    }


    $q = $mysqli->multi_query(implode(";", $updateQueries));
    if(!$q){exit(json_encode(array("error"=>"Ошибка удаления ".$mysqli->error)));}

    clearStoredResults();

    die(json_encode(array(
        'up' => $updateQueries,
        'res' => $weather
    )));
}
?>