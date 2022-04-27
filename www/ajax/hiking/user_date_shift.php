<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/dates.php"); //Только для авторизованных

$current_user = $_COOKIE["user"];
$id_user = intval($_POST['id_user']);
$id_hiking = intval($_POST['id_hiking']);
$d1 = $mysqli -> real_escape_string($_POST['d1']);
$d2 = $mysqli -> real_escape_string($_POST['d2']);

$d1 = empty($d1) ? 'NULL' : "'$d1'";
$d2 = empty($d2) ? 'NULL' : "'$d2'";

$q = $mysqli->query("SELECT is_admin FROM hiking_members WHERE id_hiking={$id_hiking} AND id_user={$current_user} LIMIT 1");
if (!$q) { exit(json_encode(array("error"=>"- \r\n".$mysqli->error))); }
$is_admin = false;
if ($q->num_rows == 1) { $is_admin = true; }

$target_user = !empty($id_user) ? $id_user : $current_user;

if ($current_user != $target_user && !$is_admin) {
    exit(json_encode(array("error"=>"access denied")));
}

$q = $mysqli->query("
    UPDATE hiking_members SET
        date_from={$d1},
        date_to={$d2}
    WHERE id_hiking={$id_hiking} AND id_user={$target_user}");
if (!$q) { exit(json_encode(array("error"=>"- \r\n".$mysqli->error))); }
exit(json_encode(array("success"=>true)));

?>
