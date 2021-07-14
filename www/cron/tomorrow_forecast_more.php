<?php
include("../blocks/db.php"); //подключение к БД

function degToCard($value) {
    $value = intval($value);
    if ($value <= 11.25) return 'N';
    $value -= 11.25;
    $allDirections = array('NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
    $dIndex = intval($value/22.5);
    return isset($allDirections[$dIndex]) ? $allDirections[$dIndex] : 'N';
}

function shortifyTime($time) {
    return (intval($time) > 12 ? $time - 12 : $time);
}

if (isset($_GET['id_hiking'])) {
    $add_where .= " AND hiking.`id`=".intval($_GET['id_hiking']);
}

$date = isset($_GET['date']) ? "'".$_GET['date']."'": 'NOW()';

$z = "SELECT `id_hiking`, `date`, `name`, `lat`, `lon`, `forecast`, `hourly_forecast`
FROM `hiking_weather` WHERE `date`=DATE({$date} + INTERVAL 1 DAY) OR  `date`=DATE({$date} + INTERVAL 2 DAY)";
$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
$points = array();
$hiking_ids = array();

while($r = $q->fetch_assoc()){
    extract($r);
    if (empty($hourly_forecast)) {
        continue;
    }

    $weather = json_decode($forecast, true);
    $r['weather'] = $weather;

    $sunset = intval($weather['sunset']);
    $sunrise = intval($weather['sunrise']);



    $hourly = json_decode($hourly_forecast, true);
    $hourFc = array();

    $lastTemp = null;
    $firstTimeOfGroup = null;
    foreach ($hourly as $h) {
        extract($h);
        if (intval($dt) < ($sunrise + 3600) || intval($dt) > ($sunset - 3600)) {
             continue;
        }
        

        $t = round($temp,0);

        $wmin = round($wind_speed,0);
        $wmax = round($wind_gust,0);
        $wdir = degToCard($wind_deg);
        $wsp = $wmin == $wmax ? $wmax : "{$wmin}-{$wmax}";
        $osCou =  isset($snow)
            ? round($snow['1h'],1)
            : round($rain['1h'],1);

        $os =  $osCou > 0 && $pop > 0
            ? (isset($snow)?'s':'r').($osCou*10)."x".round($pop * 10,0)
            : "";

        if ($lastTemp == ($t."".$osCou) && empty($firstTimeOfGroup)) {
            $firstTimeOfGroup = $time;
        } 
        

        if (empty($firstTimeOfGroup)) {
            $hourFc[] = shortifyTime(intval($time)).">{$t}{$os}";
        }

        if ($lastTemp != ($t."".$osCou)) {
            if (!empty($firstTimeOfGroup)) {
                $hourFc[] =  shortifyTime(intval($firstTimeOfGroup))."-".shortifyTime(intval($time)).">{$t}{$os}";
            }
            $firstTimeOfGroup = null;
        }
    


        
        // {$wdir}{$wsp}
        // No precipitation expected

        $lastTemp = ($t."".$osCou);

    }

    if(!isset($points[$id_hiking])) {
        $points[$id_hiking] = array();
    }

    $points[$id_hiking][] = implode("\n", $hourFc);
    if (!in_array($r['id_hiking'], $hiking_ids)) {
        $hiking_ids[] = $r['id_hiking'];
    }
}



$z = "SELECT DISTINCT
    hiking_members.id_hiking,
    user_phones.id_user, user_phones.phone,
    AES_DECRYPT(user_phones.sms_api_key, MD5(CONCAT_WS('#',user_phones.id_user,users.reg_date))) AS `sms_api_key`
FROM hiking_members
    LEFT JOIN `user_phones` ON `user_phones`.`id_user` = hiking_members.id_user
    LEFT JOIN `users` ON `user_phones`.`id_user` = users.id
WHERE
    hiking_members.id_hiking IN(".implode(",", $hiking_ids).")
    AND user_phones.is_send_sms = 1
    AND LENGTH(user_phones.sms_api_key) > 0
";
$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
$res = array();

while($r = $q->fetch_assoc()){
    extract($r);
    $res[] = $r;
    if(isset($points[$id_hiking]) && count($points[$id_hiking]) > 0) {
        $msg = "\n".implode("\n=\n",$points[$id_hiking]);
		
		if (isset($_GET['debug'])){
			$res[] = $msg;
		} else {
			$body = file_get_contents("https://sms.ru/sms/send?api_id={$sms_api_key}&to={$phone}&msg=".urlencode(iconv("windows-1251","utf-8",$msg))."&json=1");
		}
    }

}

    die(json_encode(array(
        'points' => $points,
        'res' => $res
    )));
?>