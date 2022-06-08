<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
`id`,
`id_hiking`,
`id_author`,
`date_create`,
`date_update`,
`name`,
`description`,
`date_start`,
`date_finish`,
`distance`,
`alt_ascent`,
`alt_descent`,
`speed_max`,
`speed_min`,
`speed_avg`,
`hr_max`,
`hr_min`,
`hr_avg`,
`time_mooving`
FROM
`hiking_workouts_target`
      WHERE
      hiking_workouts_target.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = $q -> fetch_assoc();
die(out($res));