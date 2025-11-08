<?php
include('../../../blocks/db.php');
// include("../../../blocks/err.php");
include('../../../blocks/sql.php');
include("../../../blocks/global.php");

$id_current_user = $_COOKIE["user"];
$id_user = intval($_GET['id_user']);
$year = intval($_GET['year']);

$file = __DIR__ . '/sql/getYearStatisticForUser.sql';

$patch = array(
    'id_user' => $id_user,
    'year' => $year,
);

$sql = getSql(
    $file,
    $patch
);


$mysqli->query("SET SESSION group_concat_max_len = 100000;");
$q = $mysqli->query($sql);
if (!$q) {
    die(err('Error update', array('message' => $mysqli->error, 'sql' => $sql, 'file' => $file)));
}
$result = array();

while ($r = $q->fetch_assoc()) {
    $result[] = $r;
}

die(jout($result));
