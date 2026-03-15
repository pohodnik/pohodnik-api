<?php
header('Content-type: application/json');
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
include("../../../blocks/sql.php");

$id_user = intval($_COOKIE["user"]);

$file = __DIR__ . '/sql/workout_targets_list.sql';

$patch = array(
  'need_filter_by_hiking' => false,
  'need_filter_by_type' => false,
  'need_filter_by_id' => true,
  'id_user' => $id_user,
  'my' => true,
  'actual' => false,
  'id' => intval($_GET['id']),
);

$z = getSql(
  $file,
  $patch
);

$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

$res = $q->fetch_assoc();

die(out($res));
