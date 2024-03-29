<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

$id_user = $_COOKIE["user"];
$id = isset($_POST['id'])?intval($_POST['id']):0;
$id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;

if(!($id>0)){die(err("id is undefined"));}

$patch = array();
if (isset($_POST['name'])) {
    $patch[] = "`name`='".$mysqli->real_escape_string($_POST['name'])."'";
}

if (isset($_POST['medical_group'])) {
    $patch[] = "`medical_group`='".$mysqli->real_escape_string($_POST['medical_group'])."'";
}

if (isset($_POST['form'])) {
    $patch[] = "`form`='".$mysqli->real_escape_string($_POST['form'])."'";
}

if (isset($_POST['dosage'])) {
    $patch[] = "`dosage`='".$mysqli->real_escape_string($_POST['dosage'])."'";
}

if (isset($_POST['for_use'])) {
    $patch[] = "`for_use`='".$mysqli->real_escape_string($_POST['for_use'])."'";
}

if (isset($_POST['contraindications'])) {
    $patch[] = "`contraindications`='".$mysqli->real_escape_string($_POST['contraindications'])."'";
}

if(!(count($patch)>0)){die(err("no changes"));}

$z = "UPDATE `medicaments` SET ".implode(",", $patch)." WHERE `id`={$id}";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z, "patch" => $patch)));}

die(out(array(
    "success" => true,
    "affected" => $mysqli->affected_rows,
    "z" => $z
)));
