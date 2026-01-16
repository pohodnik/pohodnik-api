<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/global.php");
$result=array();
$id= intval($_GET['id']);
$q = $mysqli->query("SELECT 
`id`, `name`, `protein`, `fat`, `carbohydrates`, `energy`, `weight`, `cost` FROM `recipes_products` WHERE id={$id}");
if(!$q){exit(jout(err($mysqli->error)));}
$r = $q->fetch_assoc();
exit(jout($r));
?>