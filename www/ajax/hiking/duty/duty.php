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
hiking_duty.`id`,
hiking_duty.`id_hiking`,
hiking_duty.`id_user`,
hiking_duty.`date`,
hiking_duty.`comment`,
hiking_duty.`created_at`,
hiking_duty.`creator_id`,
hiking_duty.`updated_at`,
hiking_duty.`updated_id`,
CONCAT(users.name,' ', users.surname) AS user_name,
CONCAT(cruser.name,' ', cruser.surname) AS creator_name,
CONCAT(upuser.name,' ', upuser.surname) AS updated_name
FROM `hiking_duty`

            LEFT JOIN users ON users.id = hiking_duty.`id_user`
            LEFT JOIN users as cruser ON cruser.id = hiking_duty.`creator_id`
            LEFT JOIN users as upuser ON upuser.id = hiking_duty.`updated_id`
WHERE
      hiking_duty.id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$res = array();
while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
