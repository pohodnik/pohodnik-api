<?php
include("../../blocks/db.php"); //����������� � ��
$result=array();
$q = $mysqli->query("SELECT 
`id`, `name`, `protein`, `fat`, `carbohydrates`, `energy`, `weight`, `cost` FROM `recipes_products` ORDER BY name");
if(!$q){exit(json_encode(array("error"=>"������ ��� �������. \r\n".$mysqli->error)));}
while($r = $q->fetch_assoc()){
	$result[] = $r;		
}
exit(json_encode($result));
?>