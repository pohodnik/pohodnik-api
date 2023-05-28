<?php
include("../../blocks/db.php");
include("../../blocks/for_auth.php");
include("../../blocks/err.php");
include("../../blocks/global.php");


$z = "
SELECT
        medicaments.*,
        medicaments_categories.name as category,
        medicaments_form.name as form_name
      FROM
        medicaments
        LEFT JOIN medicaments_categories ON medicaments_categories.id = medicaments.medical_group
        LEFT JOIN medicaments_form ON medicaments_form.id = medicaments.form
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
