<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных
$result = array();

$id_user = intval($_COOKIE["user"]);
$ans_ids = array();


$data = json_decode($_POST['data'], true); // {iv_qq: {v_from_input, v_from_variants, v_from_dir, v_custom}}

$rows_for_answers = array();
$rows_for_content = array();

foreach($data as $iv_qq_id => $value){
    $z = "INSERT INTO `iv_ans`(`id_qq`, `id_user`, `date`) VALUES ({$iv_qq_id},{$id_user},NOW())";
    $q = $mysqli->query($z);
    if (!$q) die(jout(err($mysqli->error, array("z" => $z))));

    $ans_id = $mysqli->insert_id;

    $ans_ids[] = $ans_id;

    $v_from_input = '';

    $v_from_variants = 0;
    $v_from_dir = 0;

    $v_custom = !empty($value['v_custom']) ? $mysqli->real_escape_string($value['v_custom']) : '';

    if (!empty($value['v_from_input'])) {
        $v_from_input = $mysqli->real_escape_string($value['v_from_input']);
        $rows_for_content[] = "({$ans_id}, '{$v_from_input}', {$v_from_variants}, {$v_from_dir}, '')";
    } else if (is_array($value['v_from_variants'])) {
        foreach ($value['v_from_variants'] as $v) {
            $rows_for_content[] = "({$ans_id}, '{$v_from_input}', {$v}, {$v_from_dir}, '')";
        }
        if (!empty($value['v_custom'])) {
            $rows_for_content[] = "({$ans_id}, '', 0, 0, '{$v_custom}')";
        }
    } else if (is_array($value['v_from_dir'])) {
        foreach ($value['v_from_dir'] as $v) {
            $rows_for_content[] = "({$ans_id}, '{$v_from_input}', {$v_from_variants}, {$v}, '')";
        }
        if (!empty($value['v_custom'])) {
            $rows_for_content[] = "({$ans_id}, '', 0, 0, '{$v_custom}')";
        }   
    }
}


$z1 = "INSERT INTO `iv_ans_content`(`id_ans`, `v_from_input`, `v_from_variants`, `v_from_dir`, `v_custom`) VALUES ".implode(',', $rows_for_content);
$q1 = $mysqli->query($z1);
if (!$q1) die(jout(err($mysqli->error, array("z" => $z1))));

die(jout(array("success" => true, "z" => $z, "z1" => $z1, "answer_ids" => $ans_ids)));

?>
