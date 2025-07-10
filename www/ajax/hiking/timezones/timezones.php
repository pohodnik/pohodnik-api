<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
hiking_timezones.`id`,
hiking_timezones.`id_hiking`,
hiking_timezones.`timezone`,
hiking_timezones.`date_in`,
hiking_timezones.`date_out`,
hiking_timezones.`comment`,
hiking_timezones.`created_at`,
hiking_timezones.`creator_id`,
hiking_timezones.`updated_at`,
hiking_timezones.`updated_id`,
CONCAT(cruser.name,' ', cruser.surname) AS creator_name,
CONCAT(upuser.name,' ', upuser.surname) AS updated_name
FROM `hiking_timezones`
    LEFT JOIN users as cruser ON cruser.id = hiking_timezones.`creator_id`
    LEFT JOIN users as upuser ON upuser.id = hiking_timezones.`updated_id`
WHERE
      hiking_timezones.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
