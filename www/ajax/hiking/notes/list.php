<?php
include("../../../blocks/db.php");
include("../../../blocks/err.php");
include("../../../blocks/global.php");

$id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;
if(!($id_hiking>0)){die(err("id_hiking is undefined"));}

$z = "SELECT
    hiking_notes.id,
    hiking_notes.id_hiking,
    hiking_notes.coordinates,
    hiking_notes.comment,
    hiking_notes.created_at,
    hiking_notes.uploaded_at,
    hiking_notes.creator_id,
    hiking_notes.updated_at,
    hiking_notes.updater_id,
    
    creator.name as creator_name,
    creator.surname as creator_surname,
    creator.photo_50 as creator_photo,

    updater.name as updater_name,
    updater.surname as updater_surname,
    updater.photo_50 as updater_photo
FROM
    `hiking_notes`
    LEFT JOIN users as creator ON creator.id = `hiking_notes`.`creator_id`
    LEFT JOIN users as updater ON updater.id = `hiking_notes`.`updater_id`
WHERE
    id_hiking={$id_hiking}
";
$q = $mysqli->query($z);
if(!$q) { die(err($mysqli->error, array("z" => $z)));}

$res = array();

while ($r = $q -> fetch_assoc()) {
    $res[] = $r;
}

die(out($res));
