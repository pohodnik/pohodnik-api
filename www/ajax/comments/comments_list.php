<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");
include("../../blocks/rules.php"); // Права доступа

global $mysqli;

$id_user = intval($_COOKIE["user"]);
$id_comments_branch = isset($_GET['id_comments_branch']) ? intval($_GET['id_comments_branch']) : null;

if (empty($id_comments_branch)) { die(err("WRONG id_comments_branch")); }

$z = "
SELECT
    comments.id,
    comments.id_comments_branch,
    comments.id_reply_comment,
    comments.id_author,
    comments.comment,
    comments.is_pinned,
    comments.created_at,
    comments.updated_at,
    comments.deleted_at,
    CONCAT(users.name, ' ', users.surname) as user_name,
    users.photo_50 as user_photo
FROM
    `comments`
    LEFT JOIN users ON users.id = comments.id_author
WHERE
    comments.id_comments_branch = {$id_comments_branch}
ORDER BY comments.`created_at`
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();
while($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
