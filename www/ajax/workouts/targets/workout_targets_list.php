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
  'need_filter_by_id' => false,
  'my' => isset($_GET['my']) && !empty(isset($_GET['my'])),
  'actual' => isset($_GET['actual']) && !empty(isset($_GET['actual'])),
  'id_user' => intval($id_user),
);

if (isset($_GET['id_hiking']) && intval($_GET['id_hiking']) > 0) {
  $patch['need_filter_by_hiking'] = true;
  $patch['id_hiking'] = intval($_GET['id_hiking']);
}

if (isset($_GET['type']) && intval($_GET['type']) > 0) {
  $patch['need_filter_by_type'] = true;
  $patch['id_type'] = intval($_GET['id_type']);
}

$z = getSql(
  $file,
  $patch
);

$q = $mysqli->query($z);
if (!$q) {
  die(err($mysqli->error, array("z" => $z)));
}

$res = array();
while ($r = $q->fetch_assoc()) {
  $res[] = $r;
}
die(out($res));
