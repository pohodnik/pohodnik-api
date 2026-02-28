<?php
$id = intval($_GET['id']);
if (!($id > 0)) {
    die(json_encode(array('error' => 'id is required')));
}
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/err.php"); //подключение к БД

$id_user = intval($_COOKIE["user"]);
ini_set('memory_limit', '256M');
global $mysqli;
$q = $mysqli->query("SET SESSION group_concat_max_len=999999;");

$z = "
SELECT
    workout_tracks.*,
    workouts.*,
    users.name as user_name, users.surname as user_surname, users.photo_50 as user_photo,
    workout_types.id as workout_type_id, workout_types.name as workout_type_name,
    hiking_tracks.id_hiking as hiking_id,
    hiking.name as hiking_name,
    hiking.ava as hiking_ava,
    hiking.start as hiking_start,
    hiking.finish as hiking_finish,
    `workouts_groups`.`name` as workout_group_name,
    track_owner.id as track_owner_id,
    track_owner.name as track_owner_name,
    track_owner.surname as track_owner_surname,
    track_owner.photo_50 as track_owner_photo
FROM
    `workouts`
    LEFT JOIN users ON users.id = workouts.id_user
    LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
    LEFT JOIN users as track_owner ON track_owner.id = workout_tracks.id_user
    LEFT JOIN workouts_groups ON workouts.workout_group = workouts_groups.id
    LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
    LEFT JOIN hiking_tracks ON hiking_tracks.id_workout_track = workout_tracks.id
    LEFT JOIN hiking ON hiking_tracks.id_hiking = hiking.id
WHERE workouts.id = {$id} LIMIT 1
";
$q = $mysqli->query($z);
if (!$q) {
    die(json_encode(array("error"=>$mysqli -> error, 'query' => $z)));
}

$res = $q -> fetch_assoc();

$res['tags'] = array();
$z = "SELECT 
    workout_tags.id as tag_id,
    workout_tags.name,
    workout_tags.color,
    workout_tags.is_personal,
    workout_tags.created_at,
    workout_tags.creator_id,
    workout_tags_usages.id,
    workout_tags_usages.created_at as usages_created_at
FROM workout_tags_usages
    LEFT JOIN workout_tags ON workout_tags.id = workout_tags_usages.id_workout_tag
WHERE workout_tags_usages.id_workout = {$id}";
$q = $mysqli->query($z);
if (!$q) { die(json_encode(array("error"=>$mysqli -> error, 'query' => $z, "kind" => "tags"))); }
while ($r = $q -> fetch_assoc()) {
    $res['tags'][] = $r;
}


$res['photos'] = array();
$z = "SELECT 
    workout_photos.id,
    workout_photos.id_workout,
    workout_photos.url_preview,
    workout_photos.url,
    workout_photos.date,
    workout_photos.altitude,
    workout_photos.comment,
    workout_photos.is_main,
    workout_photos.created_at,
    workout_photos.creator_id,
    
    ST_X(workout_photos.coordinates) as lat,
    ST_Y(workout_photos.coordinates) as lon,
    users.`name` as creator_name,
    users.`surname` as creator_surname,
    users.`photo_50` as creator_photo
FROM workout_photos
LEFT JOIN users ON users.id = workout_photos.creator_id
WHERE workout_photos.id_workout = {$id}";
$q = $mysqli->query($z);
if (!$q) { die(json_encode(array("error"=>$mysqli -> error, 'query' => $z, "kind" => "photos"))); }
while ($r = $q -> fetch_assoc()) {
    $res['photos'][] = $r;
}


exit(json_encode($res));
