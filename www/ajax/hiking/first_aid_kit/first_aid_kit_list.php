<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_user = intval($_COOKIE["user"]);
$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;

if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
        medicaments.*,
        hiking_first_aid_kit.*,
        medicaments_categories.name as category,
        medicaments_form.name as form_name,
        medicaments.id as medicament_id,
        users.name as assignee_name,
        users.surname as assignee_surname,
        users.photo_50 as assignee_photo
      FROM
        hiking_first_aid_kit
        LEFT JOIN medicaments ON medicaments.id = hiking_first_aid_kit.id_medicament
        LEFT JOIN medicaments_categories ON medicaments_categories.id = medicaments.medical_group
        LEFT JOIN medicaments_form ON medicaments_form.id = medicaments.form
        LEFT JOIN users ON `hiking_first_aid_kit`.`id_assignee` = users.id
      WHERE
        hiking_first_aid_kit.id_hiking={$id_hiking} ";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
