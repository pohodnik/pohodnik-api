<?php
header('Content-type: application/json');
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php");
include("../../blocks/sql.php");

$result = array();
$id_user = intval($_COOKIE["user"]);
$id_iv = intval($_GET['id']);
$my = boolval($_GET['my']);

$z = "SELECT id FROM `iv` WHERE iv.id={$id_iv} AND iv.`id_author`={$id_user} LIMIT 1";
$q = $mysqli->query($z);
if(!$q) die(jout(err($mysqli->error, array("z" => $z))));

$is_i_author = $q->num_rows===1;

$q = $mysqli->query("SELECT iv_ans.id FROM `iv_ans` LEFT JOIN iv_qq ON iv_ans.id_qq = iv_qq.id WHERE iv_qq.id_iv={$id_iv} AND iv_ans.`id_user`={$id_user} LIMIT 1");
if(!$q) die(jout(err($mysqli->error)));
$has_answers_from_current_user = $q->num_rows===1;


if(!$is_i_author && !$has_answers_from_current_user){
	die(jout(err('Вы не отвечали на данный опрос и/или не являетесь его автором')));
}


$file = __DIR__ . '/sql/interviewQuestionsWithAnswers.sql';

$patch = array(
    'id_iv' => $id_iv,
    'current_user' => $id_user,
    'for_current_user' => $my,
);

$z = getSql(
    $file,
    $patch
);


$qb = $mysqli->query($z);
if(!$qb) die($z); //die(jout(err($mysqli->error, array("z" => $z))));

function variant($var_str)
{
    return explode('œ', $var_str);
}

while($r=$qb->fetch_assoc()){
    if (!empty($r['params'])) {$r['params'] = explode('œ', $r['params']);} else {$r['params'] = null;}
    if (!empty($r['dir_params'])) {$r['dir_params'] = explode('œ', $r['dir_params']);} else {$r['dir_params'] = null;}
    if (!empty($r['variants'])) {$r['variants'] =  array_map('variant', explode('æ', $r['variants']));} else  {$r['variants']=null;}
    if (!empty($r['answer'])) {$r['answer'] =  array_map('variant', explode('æ', $r['answer']));} else  {$r['answer']=null;}
    
    $result[] = $r;
}
    
	
echo jout($result);