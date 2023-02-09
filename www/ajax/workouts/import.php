<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/gpx.php"); //Только для авторизованных

$token = $_GET["token"];

$q = $mysqli->query("SELECT id_user FROM `user_hash` WHERE hash='{$id_user}' LIMIT 1");
if(!$q){die(json_encode(array("error"=>"Incorrent token query ".$mysqli->error)));}	
if ($q -> num_rows === 0) { die(json_encode(array("error"=>"Invalid token")));}
$id_user = $q->fetch_assoc()['id_user'];

exit("For user ".$id_user);


global $mysqli;

$name = $mysqli->real_escape_string($_POST['name']);
$description = $mysqli->real_escape_string($_POST['description']);
$trackdata = $mysqli->real_escape_string($_POST['trackdata']);
$trackmeta = $mysqli->real_escape_string($_POST['trackmeta']);
$date_start = $mysqli->real_escape_string($_POST['date_start']);
$date_finish = $mysqli->real_escape_string($_POST['date_finish']);
$activity_type = $mysqli->real_escape_string($_POST['activity_type']);
$workout_type = isset($_POST['workout_type']) && !empty($_POST['workout_type']) ? intval($_POST['workout_type']) : 'NULL';
$bounds = $mysqli->real_escape_string($_POST['bounds']);
$distance = intval($_POST['distance']);
$alt_ascent = intval($_POST['alt_ascent']);
$alt_descent = intval($_POST['alt_descent']);
$alt_max = intval($_POST['alt_max']);
$alt_min = intval($_POST['alt_min']);
$alt_avg = intval($_POST['alt_avg']);
$speed_max = intval($_POST['speed_max']);
$speed_min = intval($_POST['speed_min']);
$speed_avg = intval($_POST['speed_avg']);
$hr_max = isset($_POST['hr_max']) ? intval($_POST['hr_max']) : 'NULL';
$hr_min = isset($_POST['hr_min']) ? intval($_POST['hr_min']) : 'NULL';
$hr_avg = isset($_POST['hr_avg']) ? intval($_POST['hr_avg']) : 'NULL';
$temp_max = isset($_POST['temp_max']) ? intval($_POST['temp_max']) : 'NULL';
$temp_min = isset($_POST['temp_min']) ? intval($_POST['temp_min']) : 'NULL';
$temp_avg = isset($_POST['temp_avg']) ? intval($_POST['temp_avg']) : 'NULL';
$time_mooving = intval($_POST['time_mooving']);
$time_pause = intval($_POST['time_pause']);
$track_id = 0;

$q = $mysqli ->query("
  SELECT
    workout_tracks.id,
    workouts.id_user
  FROM
    workouts
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
  WHERE
    workout_tracks.trackdata = '{$trackdata}'
  LIMIT 1");
if ($q && $q->num_rows == 1) {
    $r = $q -> fetch_assoc();
   if ($r['id_user'] == $id_user) {
    die(json_encode(array('error'=>"Трек уже добавлен")));
   }
   $track_id = $r['id'];
} else {
    $z = "
    INSERT INTO
        `workout_tracks`
    SET
        `id_user` = {$id_user},
        `trackdata` = '{$trackdata}',
        `trackmeta` = '{$trackmeta}',
        `date_start` = '{$date_start}',
        `date_finish` = '{$date_finish}',
        `date_upload` = NOW(),
        `date_update` = NULL,
        `activity_type` = '{$activity_type}',
        `bounds` = '{$bounds}',
        `distance` = {$distance},
        `alt_ascent` = {$alt_ascent},
        `alt_descent` = {$alt_descent},
        `alt_max` = {$alt_max},
        `alt_min` = {$alt_min},
        `alt_avg` = {$alt_avg},
        `speed_max` = {$speed_max},
        `speed_min` = {$speed_min},
        `speed_avg` = {$speed_avg},
        `hr_max` = {$hr_max},
        `hr_min` = {$hr_min},
        `hr_avg` = {$hr_avg},
        `temp_max` = {$temp_max},
        `temp_min` = {$temp_min},
        `temp_avg` = {$temp_avg},
        `time_mooving` = {$time_mooving},
        `time_pause` = {$time_pause}
    ";

    $q = $mysqli->query($z);

    if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}
    $track_id = $mysqli->insert_id;
}
$id_workout_group = 'NULL';
//check similar
$threshold_similar = 0.8; // >= 80%
$similar = 0;
$candidates = array();
$z = "
SELECT
  workout_tracks.id, workout_tracks.bounds, workout_tracks.date_start,
  workouts.id as id_workout, workouts.workout_group as id_workout_group
FROM `workout_tracks`
  LEFT JOIN workouts ON workouts.id_workout_track = workout_tracks.id
WHERE
  workout_tracks.date_start BETWEEN DATE_SUB('{$date_start}', INTERVAL 30 MINUTE) AND  DATE_ADD('{$date_start}', INTERVAL 30 MINUTE)
  AND workout_tracks.id <> {$track_id}
";
$q = $mysqli->query($z);
if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}
if ($q-> num_rows > 0) {

  $candidates = array();
  while ($r = $q -> fetch_assoc()) {
    if (isset($r['id_workout'])) {
      $bounds1 = json_decode($r['bounds'], true);
      $bounds2 = json_decode($bounds, true);
      $similar = compareBounds(array_merge(...$bounds1), array_merge(...$bounds2)); // 0...1 // can be percent
  
      if ($similar > $threshold_similar) {
        if (!isset($candidates[0]) || $candidates[0][2] > $threshold_similar) {
          $candidates[] = array($r['id_workout'], $r['id_workout_group'], $threshold_similar);
        } else {
          array_unshift($candidates, array($r['id_workout'], $r['id_workout_group'], $threshold_similar));
        }
      }
    }
  }

  if (isset($candidates[0])) {
    if(isset($candidates[0][1])) { // has Group
      $id_workout_group = $candidates[0][1];
    } else {
      $z = "
        INSERT INTO `workouts_groups` SET
          `name`='auto',
          `workout_type`={$workout_type},
          `id_user`={$id_user},
          `date_create`=NOW(),
          `date_update`=NULL
      ";
      $q = $mysqli->query($z);
      if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}
      $id_workout_group = $mysqli -> insert_id;
      $id_wo = $candidates[0][0];
      $z = "UPDATE workouts SET workout_group={$id_workout_group} WHERE id={$id_wo}";
      $q = $mysqli->query($z);
      if(!$q){die(json_encode(array(
        'error'=>$mysqli->error,
        'query' => $z,
        'candidates' => $candidates,
        'bounds' => array(
          $bounds1[0][0], $bounds1[0][1],
          $bounds1[1][0], $bounds1[1][1]
        )
      )));}
    }
  }
}

// end check similar

$z = "
INSERT INTO
    `workouts`
SET
    `id_user` = {$id_user},
    `name` = '{$name}',
    `description` = '{$description}',
    `workout_type` = {$workout_type},
    `id_workout_track` = {$track_id},
    `workout_group`={$id_workout_group},
    `date_create` = NOW(),
    `date_update` = NULL
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'query' => $z)));}

die(json_encode(array('success'=>true,'id'=>$mysqli->insert_id, "id_group" => $id_workout_group, "candidates" =>$candidates)));
