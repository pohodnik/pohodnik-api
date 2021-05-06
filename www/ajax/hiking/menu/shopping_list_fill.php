<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 0;
$product_ids = $_POST['product_ids'];

$q = $mysqli->query("
    SELECT id FROM
        `hiking_menu_shopping`
    WHERE 
        `id_hiking`={$id_hiking} AND `is_complete`=1
    LIMIT 1
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}
if($q -> num_rows == 1){die(json_encode(array('error'=>"has completed items")));}

$q = $mysqli->query("
    DELETE FROM
        `hiking_menu_shopping`
    WHERE 
        `id_hiking`={$id_hiking} AND `is_complete`=0
    LIMIT 1
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}

$q = $mysqli->query("
    INSERT INTO
        `hiking_menu_shopping`
        (`id_hiking`, `id_product`)
        VALUES
        ('[value-1]','[value-2]')
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}
$res = array();
while($r = $q->fetch_assoc()){
	$res[] = $r;
}

die(json_encode($res));