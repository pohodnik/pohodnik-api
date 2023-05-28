<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");

$name = $mysqli->real_escape_string($_POST['name']);

$z = "INSERT INTO `medicaments_form`(`name`) VALUES ('{$name}')";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array("success" => true, "id" => $mysqli->insert_id);

die(out($res));
