<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/global.php");

$res = array();
$id_user = intval($_COOKIE["user"]);

$id_hiking = intval($_POST['id_hiking']);
$comment = $mysqli->real_escape_string(trim($_POST['comment']));

if (!($id_user > 0)) die(jout(err("id_user is required")));
if (!($id_hiking > 0)) die(jout(err("id_hiking is required")));
if (!(strlen($comment) > 0)) die(jout(err("comment is required")));



$q = $mysqli->query("SELECT UNIX_TIMESTAMP(`date_finish`), id FROM iv WHERE id_hiking = {$id_hiking} AND main=1");
if(!$q) die(jout(err($mysqli->error)));
if($q -> num_rows == 1) {
    $r=$q->fetch_row();
    $deadline = $r[0];

    if(time()>$deadline){
        die(jout(err("Вы не можете отказаться от похода после даты ". date('d.m.Y H:i', $deadline ).". Interview #".$r[1])));
    }
}

$q = $mysqli->query("DELETE FROM hiking_members WHERE id_user = {$id_user} AND id_hiking = {$id_hiking}");
if(!$q){die(jout(err($mysqli->error, array("src"=>"hiking_members"))));}


$q = $mysqli->query("
    INSERT INTO
        hiking_radish
    SET
        id_user = {$id_user},
        id_hiking = {$id_hiking},
        comment='{$comment}',
        date=NOW()
");
	if(!$q) die(jout(err($mysqli->error, array("src"=>"equip"))));

	echo jout(array("success" => true, "id" => $mysqli -> insert_id));
	
/**/
?>
