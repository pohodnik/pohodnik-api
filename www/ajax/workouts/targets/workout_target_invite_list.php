<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$current_user = intval($_COOKIE["user"]);

$id_workout_target = isset($_GET['id_workout_target']) ? intval($_GET['id_workout_target']) : 0;

if (!($id_workout_target > 0)) {
  die(json_encode(array("error" => "id_workout_target is undefined")));
}


$z = "SELECT
  workout_target_invites.id,
  workout_target_invites.id_workout_target,
  workout_target_invites.id_user,
  workout_target_invites.id_author,
  workout_target_invites.created_at,
  workout_target_invites.accepted_at,
  workout_target_invites.rejected_at,
  
  workout_targets.`id`,
  workout_targets.`name`,
  workout_targets.`description`,
  workout_targets.`date_start`,
  workout_targets.`date_finish`,
  workout_targets.`workout_type`,
  workout_targets.`is_public`,
  workout_types.name as workout_type_name,
 
  author.id as author_id,
  author.name as author_name,
  author.surname as author_surname,
  author.photo_50 as author_photo,

  users.id as user_id,
  users.name as user_name,
  users.surname as user_surname,
  users.photo_50 as user_photo
FROM
  `workout_target_invites`
  LEFT JOIN workout_targets ON workout_targets.id = workout_target_invites.`id_workout_target`
  LEFT JOIN workout_types ON workout_targets.workout_type = workout_types.id
  LEFT JOIN users as author ON author.id =  workout_target_invites.`id_author`
  LEFT JOIN users ON users.id = workout_target_invites.id_user
WHERE workout_target_invites.id_workout_target={$id_workout_target}";
$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

$res = array();
while ($r = $q->fetch_assoc()) {
  $res[] = $r;
}
die(out($res));