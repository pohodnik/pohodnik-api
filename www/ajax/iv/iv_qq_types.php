<?php
include("../../blocks/db.php"); //подключение к БД
$result = array();
$q = $mysqli->query("
SELECT
    iv_qq_type.id as type_id,
    iv_qq_type.name as type_name,
    iv_qq_type.is_multi_available as type_is_multi_available,
    iv_qq_type.hint as type_hint
FROM 
    iv_qq_type
");
while($r = $q->fetch_assoc()){
	$result[] = $r;
}
echo json_encode($result);
?>