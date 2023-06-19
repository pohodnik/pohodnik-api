<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

global $mysqli;

$id_user = $_COOKIE["user"];

$id_comments_branch = isset($_POST['id_comments_branch']) ? intval($_POST['id_comments_branch']) : null;
$id_reply_comment = isset($_POST['id_reply_comment']) && $_POST['id_reply_comment']!=='null' ? intval($_POST['id_reply_comment']) : 'NULL';
$comment = isset($_POST['comment']) ? $mysqli->real_escape_string(trim($_POST['comment'])) : '';
$is_pinned = isset($_POST['is_pinned']) ? $_POST['is_pinned'] == 'true' ? 'TRUE' : 'FALSE' : null;

if (empty($id_comments_branch)) { die(err("WRONG id_comments_branch")); }

$z = "
INSERT INTO
    `comments`
SET
    `id_comments_branch` = {$id_comments_branch},
    `id_reply_comment` = {$id_reply_comment},
    `id_author` = {$id_user},
    `comment` = '{$comment}',
    `is_pinned` = {$is_pinned},
    `created_at` = NOW(),
    `updated_at` = NULL,
    `deleted_at` = NULL
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array(
    "success" => true,
    "id" => $mysqli -> insert_id,
);

die(out($res));
