<?php
header('Content-type: application/json');
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/sql.php");

$id_user = intval($_COOKIE["user"]);

$id_workout_target = isset($_GET['id_workout_target']) ? intval($_GET['id_workout_target']) : 0;

if (!($id_workout_target > 0)) {
  die(json_encode(array("error" => "id_workout_target is not defined")));
}
$z = "SELECT id_author,id_hiking FROM workout_targets WHERE id={$id_workout_target}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

$users_ids = array();
$r = $q->fetch_assoc();
$users_ids[] = $r['id_author'];


if ($r['id_hiking'] > 0) {
  $z = "SELECT id_user FROM hiking_members WHERE id_hiking=" . $r['id_hiking'];
  $q = $mysqli->query($z);
  if (!$q) {
    die(err($mysqli->error, array("z" => $z)));
  }
  while ($r = $q->fetch_assoc()) {
    $users_ids[] = $r['id_user'];
  }
}

$z = "SELECT id_user FROM workout_target_members WHERE id_workout_target={$id_workout_target}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}
while ($r = $q->fetch_assoc()) {
  $users_ids[] = $r['id_user'];
}



$file = __DIR__ . '/sql/workout_targets_stat.sql';

$patch = array(
  'id_workout_target' => $id_workout_target,
  'user_ids' => implode(',', array_unique($users_ids))
);

$z = getSql(
  $file,
  $patch
);
//die($z);
$q = $mysqli->query("SET SESSION group_concat_max_len=999999;");
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

$res = array();

while ($r = $q->fetch_assoc()) {
  $r['workouts'] = empty($r['workouts_raw']) ? array() : array_map(function ($str) {
    $parts = explode('œ', $str);

    return array(
      'id' => $parts[0],
      'name' => $parts[1],
      'date_start' => $parts[2],
      'date_finish' => $parts[3],
      'distance' => $parts[4],
      'workout_type_id' => $parts[5],
      "workout_type_name" => $parts[6]
    );
  }, explode('æ', $r['workouts_raw']));
  unset($r['workouts_raw']);
  $res[] = $r;
}
die(out($res));
