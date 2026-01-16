<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");

$id_user = intval($_COOKIE["user"]);
$id = intval($_POST['id']);
$amount = floatval($_POST['amount']);
$price = floatval($_POST['price']);
$is_complete = intval($_POST['is_complete']);
$comment = $mysqli->real_escape_string(trim($_POST['comment']));

$z = "
UPDATE
    `hiking_menu_shopping`
SET
    `amount` = {$amount},
    `price` = {$price},
    `is_complete` = {$is_complete},
    `completed_at` = ".($is_complete == 1 ? 'NOW()' : 'NULL').",
    `updated_at` = NOW(),
    `id_user` = {$id_user},
    `comment` = '{$comment}'
WHERE
    `id` = {$id}
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array('error'=>$mysqli->error, 'z' => $z)));}
die(json_encode(array('success' => true, 'affected' => $mysqli -> affected_rows)));
