<?php
header('Content-type: application/json');
include("../../blocks/db.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$id_group = isset($_GET['id_group']) ?: 0;
$id_user = isset($_GET['id_user']) ?: 0;


$where = "1";

if (isset($_GET['id_group']) && !empty($_GET['id_group'])) {
  $id_group = intval($_GET['id_group']);
  $where .= " AND `workouts`.`workout_group`={$id_group}";
}

if (isset($_GET['id_user']) && !empty($_GET['id_user'])) {
  $id_user = intval($_GET['id_user']);
  $where .= " AND `workouts`.`id_user`={$id_user}";
}

if (isset($_GET['d']) && !empty($_GET['d'])) {
  $d = $mysqli->real_escape_string($_GET['d']);
  $where .= " AND DATE(`workout_tracks`.`date_start`)=DATE('{$d}')";
}
if (isset($_GET['d1']) && !empty($_GET['d1'])) {
  $d1 = $mysqli->real_escape_string($_GET['d1']);
  $where .= " AND DATE(`workout_tracks`.`date_start`)>='{$d1}'";
}

if (isset($_GET['d2']) && !empty($_GET['d2'])) {
  $d2 = $mysqli->real_escape_string($_GET['d2']);
  $where .= " AND DATE(`workout_tracks`.`date_finish`)<='{$d2}'";
}

if (isset($_GET['tag']) && !empty($_GET['tag'])) {
  $tag = $mysqli->real_escape_string($_GET['tag']);
  $where .= " AND workout_tags_usages.id_workout_tag={$tag}";
}

if (isset($_GET['type']) && !empty($_GET['type'])) {
  $typeOrCSV = $mysqli->real_escape_string($_GET['type']);
  $where .= " AND workouts.workout_type IN({$typeOrCSV})";
}

if (isset($_GET['y']) && !empty($_GET['y'])) {
  $typeOrCSV = $mysqli->real_escape_string($_GET['y']);
  $where .= " AND YEAR(`workout_tracks`.`date_start`) IN({$typeOrCSV})";
}

$additional_fields = "";
if (isset($_GET['include_trackdata'])) {
  $additional_fields .= "`workout_tracks`.trackdata,";
}

if (isset($_GET['y']) && !empty($_GET['y'])) {
  $typeOrCSV = $mysqli->real_escape_string($_GET['y']);
  $where .= " AND YEAR(`workout_tracks`.`date_start`) IN({$typeOrCSV})";
}

global $mysqli;

$z = "
SELECT
{$additional_fields}
    `workouts`.`id`,
    `workouts`.`id_user`,
    `workouts`.`name`,
    `workouts`.`description`,
    `workouts`.`workout_type`,
    `workouts`.`workout_group`,
    `workouts_groups`.`name` as workout_group_name,
    `workout_tracks`.`id` as id_workout_track,
    `workout_tracks`.`date_start`,
    `workout_tracks`.`date_finish`,
    `workout_tracks`.`date_upload`,
    `workout_tracks`.`date_update`,
    `workout_tracks`.`activity_type`,
    `workout_tracks`.`distance`,
    `workout_tracks`.`alt_ascent`,
    `workout_tracks`.`alt_descent`,
    `workout_tracks`.`alt_max`,
    `workout_tracks`.`alt_min`,
    `workout_tracks`.`alt_avg`,
    `workout_tracks`.`speed_max`,
    `workout_tracks`.`speed_min`,
    `workout_tracks`.`speed_avg`,
    `workout_tracks`.`hr_max`,
    `workout_tracks`.`hr_min`,
    `workout_tracks`.`hr_avg`,
    `workout_tracks`.`temp_max`,
    `workout_tracks`.`temp_min`,
    `workout_tracks`.`temp_avg`,
    `workout_tracks`.`time_mooving`,
    `workout_tracks`.`time_pause`,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name,
    hiking_tracks.id_hiking as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,
    GROUP_CONCAT(
        DISTINCT CONCAT_WS(
            'œ',
            workout_tags.id,
            workout_tags.name,
            workout_tags.color,
            workout_tags.is_personal
        ) SEPARATOR 'æ'
    ) AS tags_raw,
    GROUP_CONCAT(
        DISTINCT CONCAT_WS(
            'œ',
            workout_photos.id,
            workout_photos.url_preview,
            workout_photos.url,
            workout_photos.is_main
        ) SEPARATOR 'æ'
    ) AS photos_raw
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
    LEFT JOIN workouts_groups ON workouts.workout_group = workouts_groups.id
    LEFT JOIN hiking_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
    LEFT JOIN hiking ON hiking_tracks.id_hiking = hiking.id
    LEFT JOIN workout_tags_usages ON workout_tags_usages.id_workout = workouts.id
    LEFT JOIN workout_tags ON workout_tags.id = workout_tags_usages.id_workout_tag
    LEFT JOIN workout_photos ON workout_photos.id_workout = workouts.id AND workout_photos.is_main=1
WHERE
    {$where}
    
GROUP BY workouts.id
ORDER BY workout_tracks.date_start DESC

LIMIT {$limit} OFFSET {$offset}
";
$q = $mysqli->query($z);
if (!$q) {
  die(json_encode(array("error" => $mysqli->error, 'query' => $z)));
}

$res = array();

while ($r = $q->fetch_assoc()) {

  $r['tags'] = empty($r['tags_raw']) ? array() : array_map(function ($str) {
    $parts = explode('œ', $str);
    return array(
      'id' => $parts[0],
      'name' => $parts[1],
      'color' => $parts[2],
      'is_personal' => $parts[3]
    );
  }, explode('æ', $r['tags_raw']));

  $r['photos'] = empty($r['photos_raw']) ? array() : array_map(function ($str) {
    $parts = explode('œ', $str);
    return array(
      'id' => $parts[0],
      'url_preview' => $parts[1],
      'url' => $parts[2],
      'is_main' => $parts[3]
    );
  }, explode('æ', $r['photos_raw']));
  $res[] = $r;
}


exit(json_encode($res));
