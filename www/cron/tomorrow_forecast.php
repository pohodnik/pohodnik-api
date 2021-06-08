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

function translit($value)
{
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
	);
 
	$value = strtr($value, $converter);
	return $value;
}

if (isset($_GET['id_hiking'])) {
    $add_where .= " AND hiking.`id`=".intval($_GET['id_hiking']);
}

$z = "SELECT `id_hiking`, `date`, `name`, `lat`, `lon`, `forecast`
FROM `hiking_weather` WHERE `date`=DATE(NOW() + INTERVAL 1 DAY) OR  `date`=DATE(NOW() + INTERVAL 2 DAY)";
$q = $mysqli->query($z);
if(!$q){exit(json_encode(array("error"=>"Ошибка ".$mysqli->error)));}
$points = array();
$hiking_ids = array();

while($r = $q->fetch_assoc()){
    extract($r);
    $weather = json_decode($forecast, true);
    $r['weather'] = $weather;
    $fc = array(
        'name' => substr(translit($name), 0, 6),
        'date' => date('d.m', $weather['dt']),
        'desc' => substr($weather['weather'][0]['main'], 0, 6),
        'temp' => "T(".implode(',', array(
            "n".round($weather['temp']['night']),
            "m".round($weather['temp']['morn']),
            "d".round($weather['temp']['day']),
            "e".round($weather['temp']['eve']),
            "min".round($weather['temp']['min']),
            "max".round($weather['temp']['max']),
        )).")",
        'humidity' => "h".$weather['humidity']."%",
        'clouds' => "c".$weather['clouds']."%",
        'wind' => degToCard($weather['deg'])."=".round($weather['speed'])."-".round($weather['gust']),
        'rainSnow' => (isset($weather['snow']) ? 's'.round($weather['snow']) : 'r'.round($weather['rain']))."mm(".round($weather['pop'] * 100)."%)"
    );

    if(!isset($points[$id_hiking])) {
        $points[$id_hiking] = array();
    }

    $points[$id_hiking][] = implode("\n", array_values($fc));
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
$points = array();

while($r = $q->fetch_assoc()){
    extract($r);
    $res[] = $r;
    if(isset($points[$id_hiking]) && count($points[$id_hiking]) > 0) {
        $msg = implode("\n-\n",$points[$id_hiking]);
		
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