<?
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$name = $mysqli->real_escape_string(trim($_POST['name']));
$weight = intval($_POST['weight']);
$value = floatval($_POST['value']);
$is_musthave = intval($_POST['is_musthave']);
$is_group = intval($_POST['is_group']);
$id = isset($_POST['id'])?intval($_POST['id']):0;
$id_parent = isset($_POST['id_parent'])?intval($_POST['id_parent']):'NULL';
$is_archive = isset($_POST['is_archive'])?boolval($_POST['is_archive']) ? 1 : 0 : 0;
$category =  isset($_POST['category']) && !empty(trim($_POST['category']))
    ? $mysqli->real_escape_string(trim($_POST['category']))
    : NULL;

$photo = isset($_POST['photo'])?$mysqli->real_escape_string(trim($_POST['photo'])):'';
$id_user = $_COOKIE["user"];
$z = ($id>0?"UPDATE":"INSERT INTO")." `user_equip` SET 
 `id_user`={$id_user},
 `name`='{$name}',
 `weight`={$weight},
 `value`={$value},
 `is_musthave`={$is_musthave},
 `is_group`={$is_group},
 `photo` = '{$photo}',
 `id_parent` = {$id_parent},
 `is_archive` = {$is_archive},
 `category`=".( is_null($category) ? 'NULL' : "'{$category}'" )."
 ".($id>0?" WHERE id={$id}":"");

$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}
if(!$id>0){$id=$mysqli->insert_id;}
die(json_encode(array("success"=>true, "id"=>$id)));