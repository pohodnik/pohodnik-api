<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");


$result = array();
$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_GET['id_hiking']) ? intval($_GET['id_hiking']) : 0;
$z = "
SELECT
    hiking_menu_shopping.`id`,
    hiking_menu_shopping.`id_hiking`,
    hiking_menu_shopping.`id_product`,
    hiking_menu_shopping.`amount`,
    hiking_menu_shopping.`need_amount`,
    hiking_menu_shopping.`usages`,
    hiking_menu_shopping.`price`,
    hiking_menu_shopping.`is_complete`,
    hiking_menu_shopping.`completed_at`,
    hiking_menu_shopping.`updated_at`,
    hiking_menu_shopping.`id_user`,
    hiking_menu_shopping.`comment`,
    recipes_products.name,
    users.name as uname,
    users.surname as usurname,
    users.photo_50 as uphoto
FROM
    `hiking_menu_shopping`
    LEFT JOIN recipes_products ON recipes_products.id = hiking_menu_shopping.id_product
    LEFT JOIN users ON users.id = hiking_menu_shopping.id_user
WHERE
    hiking_menu_shopping.id_hiking = {$id_hiking}
ORDER BY
    hiking_menu_shopping.`is_complete` 
";

$q = $mysqli->query("SET SESSION group_concat_max_len=999999;");

$q = $mysqli->query($z);
if(!$q){die(json_encode(array('error'=>$mysqli->error, 'z' => $z)));}
$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(json_encode($res));
