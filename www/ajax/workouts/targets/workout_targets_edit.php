<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = intval($_COOKIE["user"]);
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (!($id > 0)) {
  die(err("id is undefined"));
}

$patch = array();

if (isset($_POST['name'])) {
  $patch[] = "`name`='" . $mysqli->real_escape_string($_POST['name']) . "'";
}

if (isset($_POST['description'])) {
  $patch[] = "`description`='" . $mysqli->real_escape_string($_POST['description']) . "'";
}

if (isset($_POST['date_start'])) {
  $patch[] = "`date_start`='" . $mysqli->real_escape_string($_POST['date_start']) . "'";
}

if (isset($_POST['date_finish'])) {
  $patch[] = "`date_finish`='" . $mysqli->real_escape_string($_POST['date_finish']) . "'";
}

if (isset($_POST['distance'])) {
  $patch[] = "`distance` = " . (empty($_POST['distance']) ? 'NULL' : intval($_POST['distance']));
}
if (isset($_POST['alt_ascent'])) {
  $patch[] = "`alt_ascent` = " . (empty($_POST['alt_ascent']) ? 'NULL' : intval($_POST['alt_ascent']));
}
if (isset($_POST['alt_descent'])) {
  $patch[] = "`alt_descent` = " . (empty($_POST['alt_descent']) ? 'NULL' : intval($_POST['alt_descent']));
}
if (isset($_POST['speed_max'])) {
  $patch[] = "`speed_max` = " . (empty($_POST['speed_max']) ? 'NULL' : intval($_POST['speed_max']));
}
if (isset($_POST['speed_min'])) {
  $patch[] = "`speed_min` = " . (empty($_POST['speed_min']) ? 'NULL' : intval($_POST['speed_min']));
}
if (isset($_POST['speed_avg'])) {
  $patch[] = "`speed_avg` = " . (empty($_POST['speed_avg']) ? 'NULL' : intval($_POST['speed_avg']));
}
if (isset($_POST['hr_max'])) {
  $patch[] = "`hr_max` = " . (empty($_POST['hr_max']) ? 'NULL' : intval($_POST['hr_max']));
}
if (isset($_POST['hr_min'])) {
  $patch[] = "`hr_min` = " . (empty($_POST['hr_min']) ? 'NULL' : intval($_POST['hr_min']));
}
if (isset($_POST['hr_avg'])) {
  $patch[] = "`hr_avg` = " . (empty($_POST['hr_avg']) ? 'NULL' : intval($_POST['hr_avg']));
}
if (isset($_POST['time_mooving'])) {
  $patch[] = "`time_mooving` = " . (empty($_POST['time_mooving']) ? 'NULL' : intval($_POST['time_mooving']));
}
if (isset($_POST['workout_type'])) {
  $patch[] = "`workout_type` = " . (empty($_POST['workout_type']) ? 'NULL' : intval($_POST['workout_type']));
}
if (isset($_POST['is_public'])) {
  $patch[] = "`is_public` = " . (boolval($_POST['is_public']) ? 'TRUE' : 'FALSE');
}
if (isset($_POST['id_hiking'])) {
  $patch[] = "`id_hiking` = " . (empty($_POST['id_hiking']) ? 'NULL' : intval($_POST['id_hiking']));
}

if (!(count($patch) > 0)) {
  die(err("no changes"));
}


$z = "UPDATE `workout_targets` SET " . implode(",", $patch) . ", date_update=NOW() WHERE `id`={$id} AND id_author={$id_user}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z, "patch" => $patch)));
}

die(out(array(
  "success" => true,
  "affected" => $mysqli->affected_rows
)));