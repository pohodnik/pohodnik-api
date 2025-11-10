<?php
include("../../blocks/db.php"); //подключение к БД
$result = array();
$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 0;
$clous = "";
if (isset($_GET['region'])) {
    $clous .= " AND geo_regions.id=" . intval($_GET['region']);
}
$q = $mysqli->query("
SELECT 
    routes.id, 
    routes.name, 
    routes.desc,
    routes.length, 
    routes.date_create,
    routes.preview_img,

    routes.id_author,
    users.name AS author_name,
    users.surname AS author_surname,
    users.photo_50 AS author_photo,

    (
        SELECT
            GROUP_CONCAT(CONCAT_WS(
                'œ',
                hiking.id,
                hiking.name,
                hiking.ava,
                hiking.start,
                hiking.finish
            ))
        FROM hiking WHERE hiking.id_route = routes.id
    ) AS hiking,
        (
        SELECT
            count(*)
        FROM hiking WHERE hiking.id_route = routes.id
    ) AS hiking_count,
    (
        SELECT
            SUM(
                IF(route_objects.is_in_distance=1, route_objects.distance, 0)
            )
        FROM route_objects
        WHERE route_objects.id_route=routes.id
    ) AS distance,

    (SELECT GROUP_CONCAT(
        CONCAT_WS(
            'œ',
            editor.id,
            editor.name,
            editor.surname,
            editor.photo_50
        )
    )
        FROM route_editors 
        LEFT JOIN users AS editor ON route_editors.id_user=editor.id WHERE route_editors.id_route=routes.id
    ) AS editors,

    GROUP_CONCAT(
        CONCAT_WS(
            'œ',
            geo_regions.id,
            geo_regions.name
        )
    ) AS regions

    FROM `routes`
    
        LEFT JOIN users ON users.id = routes.id_author
        LEFT JOIN route_regions ON route_regions.id_route=routes.id
        LEFT JOIN geo_regions ON route_regions.id_region=geo_regions.id
    WHERE
        1
        {$clous}
    GROUP BY
        routes.id
    ORDER BY
    hiking_count DESC,
        routes.date_create

");
if ($q && $q->num_rows > 0) {
    while ($r = $q->fetch_assoc()) {
        $result[] = $r;
    }
    echo json_encode($result);
} else {
    exit(json_encode(array("error" => "Ошибка при получении данных пользователя. \r\n" . $mysqli->error)));
}