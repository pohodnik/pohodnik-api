<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
$id = intval($_POST['id']);
$assign_user = intval($_POST['assign_user']);

$id_user = $_COOKIE["user"];

$z = "
	SELECT
		`id_set`, `amount`, `id_equip`, `is_check`, `date_confirm`, `user_confirm`, `from_user`
	FROM
		`user_equip_set_items`
	WHERE
		id={$id}
";

$q = $mysqli -> query($z);
if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }
$setItems = $q -> fetch_assoc();
$id_set = $setItems['id_set'];

$z = "
	SELECT
		`id`, `id_user`, `id_hiking`, `id_backpack`, `name`, `description`, `date_update`
	FROM
		`user_equip_sets`
	WHERE
		id = {$id_set}
";

$q = $mysqli -> query($z);
if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }
$donorSet = $q -> fetch_assoc();
$id_hiking = $donorSet['id_hiking'];

$z = "
	SELECT
		`id`, `id_user`, `id_hiking`, `id_backpack`, `name`, `description`, `date_update`
	FROM
		`user_equip_sets`
	WHERE
		id_user = {$assign_user} AND id_hiking = {$id_hiking}
";

$q = $mysqli -> query($z);
if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }
if ($q -> num_rows == 0) {
	$z = "
		INSERT INTO `user_equip_sets`
		(`id_user`, `id_hiking`, `id_backpack`, `name`, `description`, `date_update`)
		SELECT {$assign_user} AS id_user, id_hiking, NULL AS id_backpack, name, description, NOW() AS date_update
		FROM user_equip_sets WHERE id = {$setItems['id_set']}
	";

	$q = $mysqli -> query($z);
	if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }
	$id_new_set = $mysqli -> insert_id;
} else {
	$set = $q -> fetch_assoc();
	$id_new_set = $set['id'];
}

$z = "
	INSERT INTO `user_equip_set_items`(`id_set`, `amount`, `id_equip`, `is_check`, `date_confirm`, `user_confirm`, `from_user`)
	VALUES ({$id_new_set},{$setItems['amount']},{$setItems['id_equip']},0,NULL,NULL,{$id_user})
";
$q = $mysqli -> query($z);
if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }

$ins_id = $mysqli -> insert_id;

$z = "DELETE FROM `user_equip_set_items` WHERE id={$id}";
$q = $mysqli -> query($z);
if (!$q) { die(json_encode(array('error' => $mysqli -> error, 'z' => $z))); }


die(json_encode(array('success' => true, 'id' => $ins_id, 'deleted' => $mysqli -> affected_rows, 'id_set' => $id_new_set)));