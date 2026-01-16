<?php // СПИСКИ
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных
$result = array();
$data = json_decode($_POST['data'], true); // {name: string; index: number}[]
$id_qq = intval($_POST['id_qq']);

$q = $mysqli->query("DELETE FROM iv_qq_params_variants WHERE id_qq={$id_qq}");
if (!$q) die(jout(err($mysqli->error)));

if(is_array($data)){
    $rows = array();

	for($i=0; $i<count($data); $i++){
        $value = $data[$i]['name'];
        $index = $data[$i]['index'];
        $rows[] = "({$id_qq},'{$value}',$index)";
	}
}

if (count($rows) > 0) {
    $z = "INSERT INTO `iv_qq_params_variants`(`id_qq`, `value`, `order_index`) VALUES ".implode(',', $rows);
    $q = $mysqli->query($z);
    if (!$q) die(jout(err($mysqli->error)));

    $z = "SELECT `id`, `value`, `order_index` FROM `iv_qq_params_variants` WHERE `id_qq` = {$id_qq} ORDER BY order_index";
    $q = $mysqli->query($z);
    if (!$q) die(jout(err($mysqli->error)));
    while($r=$q->fetch_assoc()) {
        $result[] = $r;
    }
}

echo json_encode($result);

?>