<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных

$result = array();
$id = intval($_POST['id']);
$name = $mysqli->real_escape_string($_POST['name']);
$value = $mysqli->real_escape_string($_POST['value']);
$id_user = intval($_COOKIE["user"]);

if ($name == 'preview_img' && $id > 0) {
    include("../../blocks/imagesStorage.php"); //Только для авторизованных
    include(__DIR__."/../../vendor/autoload.php"); //Только для авторизованных
    $z = "SELECT preview_img FROM routes WHERE id={$id} LIMIT 1";
    $q = $mysqli->query($z);
    if (!$q) {
        die(json_encode(array("error"=>$mysqli->error)));
    }
    $r = $q -> fetch_assoc();
    $oldPhoto = $r['preview_img'];

    if (!empty($oldPhoto)) {
        if (isUrlCloudinary($oldPhoto)) {
            deleteCloudImageByUrl($oldPhoto);
        }
    }
}

$q = $mysqli->query("UPDATE `routes` SET `{$name}`='{$value}' WHERE id={$id}");
if(!$q){die(json_encode(array("error"=>$mysqli->error)));}

die(json_encode(array("success"=>true)));
