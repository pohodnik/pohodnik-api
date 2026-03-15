<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);
$id_workout_target_invite = isset($_POST['id_workout_target_invite']) ? intval($_POST['id_workout_target_invite']) : 0;

if (!($id_workout_target_invite > 0)) {
  die(json_encode(array("error" => "id_workout_target_invite is undefined")));
}

$z = "SELECT id_workout_target FROM `workout_target_invites` WHERE id_user={$current_user} AND id={$id_workout_target_invite} LIMIT 1";
$q = $mysqli->query($z);
if ($q && $q->num_rows === 0) die(json_encode(array("error" => "workout_target_invite is not found")));

$r = $q->fetch_assoc();
$id_workout_target = $r['id_workout_target'];


$z = "INSERT INTO `workout_target_members`(
    `id_workout_target`,
    `id_user`,
    `created_at`
)
VALUES(
  {$id_workout_target},
  {$current_user},
  NOW()
)";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}
$new_workout_member_id = $mysqli->insert_id;

$z = "UPDATE `workout_target_invites` SET accepted_at=NOW() WHERE id={$id}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

die(out(array(
  "success" => true,
  "affected" => $mysqli->affected_rows,
  "id" => $new_workout_member_id
)));
