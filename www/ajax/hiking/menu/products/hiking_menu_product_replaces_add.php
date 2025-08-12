<?php
    include("../../../../blocks/db.php");
    include("../../../../blocks/for_auth.php");
    include("../../../../blocks/err.php");
    include("../../../../blocks/global.php");
    include("../../../../blocks/rules.php");

    $current_user = $_COOKIE["user"];

    $id_hiking = isset($_POST['id_hiking'])?intval($_POST['id_hiking']):0;
    $id_source_product = isset($_POST['id_source_product'])?intval($_POST['id_source_product']):0;
    $id_target_product = isset($_POST['id_target_product'])?intval($_POST['id_target_product']):0;
    $rate = isset($_POST['rate'])?floatval($_POST['rate']):1;

    $comment = $mysqli->real_escape_string($_POST['comment']);

    if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
    if(!($id_source_product>0)){die(json_encode(array("error"=>"id_source_product is undefined")));}
    if(!($id_target_product>0)){die(json_encode(array("error"=>"id_target_product is undefined")));}

    $hasRules = hasHikingRules($id_hiking, array('boss', 'kitchen'));
    if (!$hasRules) { die(json_encode(array("error"=>"У вас нет доступа"))); }

    $z = "
    INSERT INTO
        `hiking_menu_products_replace`
    SET
        `id_hiking` = {$id_hiking},
        `id_source_product` = {$id_source_product},
        `id_target_product` = {$id_target_product},
        `comment` = '{$comment}',
        `rate`={$rate},
        `created_at` = NOW(),
        `creator_id` = {$current_user}
    ";
    $q = $mysqli->query($z);
    if(!$q) { die(err($mysqli->error, array("z" => $z)));}

    die(out(array(
        "success" => true,
        "affected" => $mysqli->affected_rows,
        "id" => $mysqli->insert_id
    )));
