<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

global $mysqli;

$id_user = $_COOKIE["user"];

$id_comment = isset($_POST['id_comment']) ? intval($_POST['id_comment']) : null;
$is_pinned = isset($_POST['is_pinned']) ? $_POST['is_pinned'] == 'true' ? 'TRUE' : 'FALSE' : null;

if (empty($id_comment)) { die(err("WRONG id_comment")); }

$z = "SELECT id_comments_branch FROM comments  WHERE id={$id_comment} LIMIT 1";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}
$id_comments_branch = $q->fetch_row()[0];

$z = "
UPDATE
    `comments`
SET
    `is_pinned` = FALSE
WHERE id_comments_branch={$id_comments_branch}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}


$z = "
UPDATE
    `comments`
SET
    `is_pinned` = {$is_pinned}
WHERE id={$id_comment} AND `id_author` = {$id_user}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array(
    "success" => $is_pinned == 'FALSE' || $mysqli -> affected_rows > 0
);

die(out($res));
