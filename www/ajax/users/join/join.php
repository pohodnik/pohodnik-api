<?php
	include('../../../blocks/db.php');
	include("../../../blocks/for_auth.php");
    include('../../../blocks/sql.php');
	include("../../../blocks/resp.php");

    $id_new_user = intval($_GET['id_new_user']);
    $id_old_user = intval($_GET['id_old_user']);


	$file = __DIR__.'/joinUsers.sql';
    $patch = array(
        'id_new_user' => $id_new_user,
        'id_old_user' => $id_old_user,
    );

    $sql = getSql(
        $file,
        $patch
    );

    die($sql);
    $q = $mysqli->query($sql);
    if (!$q) { die(err('Error update', array('message' => $mysqli->error, 'sql' => $sql, 'file'=>$file))); }

    if($mysqli->affected_rows == 0) { die(err('no affected', array('affected' => $mysqli->affected_rows))); }


    die(jout(array('success' => true, "affected" => $mysqli->affected_rows)));

?>