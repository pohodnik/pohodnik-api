<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/imagesStorage.php"); //Только для авторизованных

$name = $mysqli->real_escape_string(trim($_POST['name']));
$weight = intval($_POST['weight']);
$value = floatval($_POST['value']);
$is_musthave = intval($_POST['is_musthave']);
$is_group = intval($_POST['is_group']);

$id = isset($_POST['id'])
        ? intval($_POST['id'])
        : 0;

$id_parent = isset($_POST['id_parent']) && !empty($_POST['id_parent'])&& $_POST['id_parent'] !== 'null'
            ? intval($_POST['id_parent'])
            : 'NULL';

$id_category = isset($_POST['id_category']) && $_POST['id_category'] > 0 && $_POST['id_category'] !== 'null'
                ? intval($_POST['id_category'])
                : 'NULL';
$is_archive = isset($_POST['is_archive'])
                ? $_POST['is_archive'] ? 1 : 0
                : 0;

$category = isset($_POST['category']) && !empty(trim($_POST['category']))
            ? $mysqli->real_escape_string(trim($_POST['category']))
            : NULL;

$photo = isset($_POST['photo'])
            ? $mysqli->real_escape_string(trim($_POST['photo']))
            : '';

$id_user = intval($_COOKIE["user"]);

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
 `id_category` = {$id_category},
 `category`=".( is_null($category) ? 'NULL' : "'{$category}'" )."
 ".($id>0?" WHERE id={$id}":"");

$q = $mysqli->query($z);
if(!$q){die(json_encode(array("error"=>$mysqli->error, "z" => $z)));}

if ($id > 0) {
    $z = "SELECT photo FROM user_equip WHERE id={$id} LIMIT 1";
    $q = $mysqli->query($z);
    if (!$q) {
        die(json_encode(array("error"=>$mysqli->error)));
    }
    $r = $q -> fetch_row();
    $oldPhoto = $r[0];
    if (!empty($oldPhoto)) {
        $z = "SELECT photo FROM user_equip WHERE photo='{$oldPhoto}' LIMIT 1";
        $q = $mysqli->query($z);
        if ($q -> num_rows === 0) {
            if (isUrlCloudinary($oldPhoto)) {
				deleteCloudImageByUrl($oldPhoto);
			} else if(is_file("../../".$oldPhoto)){
				unlink("../../".$oldPhoto);
			}
        }
    }
}

if(!$id>0){$id=$mysqli->insert_id;}
die(json_encode(array("success"=>true, "id"=>$id)));
