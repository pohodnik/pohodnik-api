<?php
include("../blocks/db.php"); //подключение к БД
$current_user = $_COOKIE["user"];
$id_recipient = $_POST['id_recipient'];
$z = "SELECT 
hiking.`id`, hiking.`start`, hiking.`finish`,
GROUP_CONCAT(DISTINCT CONCAT_WS (',', hiking_keypoints.date, hiking_keypoints.lat, hiking_keypoints.lon) SEPARATOR '|') AS keypoints
FROM 
`hiking` 
LEFT JOIN hiking_keypoints ON hiking_keypoints.id_hiking = hiking.id
WHERE
hiking.`start` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 16 DAY)
OR hiking.`finish` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 16 DAY)
GROUP BY hiking.id
";

$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
$res = array();
if ($q -> num_rows > 0) {
    while ($r = $q -> fetch_assoc()) {
        extract($r);
        $t1 = strtotime($start);
        $t2 = strtotime($finish);
        $kp = explode("|", $keypoints);

        $kpd = array();
        foreach($kp as $v) {
            $a = explode(',', $v);
            $date = $a[0];
            $lat = $a[1];
            $lon = $a[2];
            $kpd[$date] = implode(',', array($a[1], $a[2]));
        }

        $curKey = array_keys( $kpd )[0];

        $siq = [];
        $cur = $t1;
        $res[$id] = array();

        $startToday = strtotime(date('Y-m-d')." 00:00:00");

        while($cur <= $t2) {

            if ( $cur < $startToday) {
                $cur += 86400;
                continue;
            }

            $isoDate = date('Y-m-d', $cur);
            if (isset($kpd[$isoDate])) {
                $curKey = $isoDate;
            }

            if (!isset($res[$id][$kpd[$curKey]])) {
                $res[$id][$kpd[$curKey]] = array(
                    'latlngs' => explode(',', $kpd[$curKey]),
                    'min' => $isoDate,
                    'count' => 0
                );
            }

            $res[$id][$kpd[$curKey]]['max'] = $isoDate;
            $res[$id][$kpd[$curKey]]['count'] += 1;

            $cur += 86400;
        }
    }

$deleteQueries = array();
$insertValues = array();


    foreach($res as $id_hiking => $latlngs) {
        foreach($latlngs as $latlng => $params) {
            $lat = $params['latlngs'][0];
            $lon = $params['latlngs'][1];
            $lim = ceil((strtotime($params['max']." 23:59:59") - time()) / 86400);
            $limit = $lim > 16 ? 16 : $lim;
            $url =  "http://api.openweathermap.org/data/2.5/forecast/daily?units=metric&lat={$lat}&lon={$lon}&cnt={$limit}&APPID=2c7ee5aa0cd9ccedbcb6c836b605c24c&lang=ru";
            $res[$id_hiking][$latlng]['url'] = $url;
            $body = file_get_contents($url);
            $weather = json_decode($body, true);
            $res[$id_hiking][$latlng]['city'] = array(
                'name' => $weather['city']['name'],
                'lat' => $weather['city']['coord']['lat'],
                'lon' => $weather['city']['coord']['lon']
            );
            $res[$id_hiking][$latlng]['forecast'] = array();
            foreach($weather['list'] as $oneweather) {
                if ($oneweather['dt'] >= strtotime($params['min']." 00:00:00") && $oneweather['dt'] <= strtotime($params['max']." 23:59:59")) {
                    $res[$id_hiking][$latlng]['forecast'][] = $oneweather;
                    $isoD = date('Y-m-d', $oneweather['dt']);
                    $insertQueries[] =  "({$id_hiking},'{$isoD}','{$weather['city']['name']}',{$weather['city']['coord']['lat']},{$weather['city']['coord']['lon']},'".(json_encode($oneweather))."')";
                    $deleteQueries[] = "(date='$isoD' AND id_hiking={$id_hiking})";
                }
            }
        }
    }

// $lat = 0;
// $lon = 0;
// $limit = 16;

//     $url =  "http://api.openweathermap.org/data/2.5/forecast/daily?units=metric&lat={$lat}&lon={$lon}&cnt={$limit}&APPID=2c7ee5aa0cd9ccedbcb6c836b605c24c&lang=ru";
   
//     $body = file_get_contents("https://sms.ru/sms/send?api_id={$sms_api_key}&to={$phone}&msg=".urlencode(iconv("windows-1251","utf-8",$msg))."&json=1"); # Если приходят крякозябры, то уберите iconv и оставьте только urlencode("Привет!")
$z = "INSERT INTO `hiking_weather`
(`id_hiking`, `date`, `name`, `lat`, `lon`, `forecast`) VALUES ";

$q = $mysqli->query("DELETE FROM hiking_weather WHERE ".implode(" OR ", $deleteQueries));
if(!$q){exit(json_encode(array("error"=>"Ошибка удаления ".$mysqli->error)));}

$q = $mysqli->query($z.implode(",", $insertQueries));
if(!$q){exit(json_encode(array("error"=>"Ошибка добавления ".$mysqli->error."\r\n".$z.implode(",", $insertQueries))));}

    die(json_encode(array(
        'del' => $deleteQueries,
        'insert' => $insertQueries,
        'res' => $res
    )));
}
?>