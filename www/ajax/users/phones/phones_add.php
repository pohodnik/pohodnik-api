<?php
include('../../../blocks/db.php');
include("../../../blocks/for_auth.php");
$phone = $mysqli->real_escape_string(trim($_POST['phone']));
$sms_api_key = $mysqli->real_escape_string(trim($_POST['sms_api_key']));
$id = intval($_POST['id']);
$is_contact = intval($_POST['is_contact']);
$is_send_sms = intval($_POST['is_send_sms']);

$id_user = intval($_COOKIE["user"]);

$key = "secret";

if (strlen($sms_api_key) > 0) {
    $q = $mysqli->query("SELECT reg_date from users WHERE id={$id_user} LIMIT 1");
    if (!$q) {
        die(json_encode(array("error" => $mysqli->error)));
    }
    $r = $q->fetch_assoc();
    $reg_date = $r['reg_date'];
    $key = md5($id_user . "#" . $reg_date);
}
//,
$q = $mysqli->query(($id > 0 ? "UPDATE" : "INSERT INTO") . " `user_phones` SET
    `id_user`={$id_user},
    `phone`='{$phone}',
    `is_contact`={$is_contact},
    `is_send_sms`={$is_send_sms},
    `sms_api_key`=" . (strlen($sms_api_key) > 0 ? "AES_ENCRYPT('{$sms_api_key}', '{$key}')" : "NULL") . "
    " . ($id > 0 ? " WHERE `id`={$id}" : ""));
if (!$q) {
    die(json_encode(array("error" => $mysqli->error)));
}
die(json_encode(array("success" => true, "id" => $mysqli->insert_id)));
