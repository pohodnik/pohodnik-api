<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/imagesStorage.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных
include(__DIR__ . "/../../vendor/autoload.php"); //Только для авторизованных

$possible_keys = explode(',', 'email,name,surname,dob,ava,address,phone,skype,icq,weight,growth,id_region,photo_50,photo_100,photo_200_orig,photo_max,photo_max_orig,uniq_code,sex');
$img_keys = explode(',', 'ava,photo_50,photo_100,photo_200_orig,photo_max,photo_max_orig');

$id_user = intval($_COOKIE["user"]);

$need_to_remove_img = array();
$update_parts = array();

foreach ($_POST as $raw_key => $raw_value) {
  $key = $mysqli->real_escape_string(trim($raw_key));
  $value = $mysqli->real_escape_string(trim($raw_value));

  if (in_array($key, $img_keys)) {
    $need_to_remove_img[] = $key;
  }

  if (in_array($key, $possible_keys)) {
    $update_parts[] = "`{$key}`='{$value}'";
  }
}

if (count($need_to_remove_img) > 0) {
  $q = $mysqli->query("SELECT `".implode('`, `', $need_to_remove_img)."` FROM users WHERE id={$id_user} LIMIT 1");
  if ($q && $q->num_rows === 1) {
    $r = $q->fetch_assoc();

    foreach ($r as $fk => $filename) {
      if (isUrlCloudinary($filename)) {
        deleteCloudImageByUrl($filename);
      } else if (is_file($filename)) {
        unlink($filename);
      } else if (is_file('../../' . $filename)) {
        unlink('../../' . $filename);
      }
    }
  }
}

if (count($update_parts) > 0) {
  $q = $mysqli->query("UPDATE users SET ".implode(',', $update_parts)." WHERE id={$id_user}");
  if (!$q) { die(jout(err($mysqli->error, array("update_parts" => $update_parts)))); }
  die(jout(array("success" => true, "update_parts" => $update_parts, "removed_images_keys" => $need_to_remove_img)));
}
