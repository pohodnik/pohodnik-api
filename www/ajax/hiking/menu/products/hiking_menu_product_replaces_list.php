<?php
    include("../../../../blocks/db.php");
    include("../../../../blocks/for_auth.php");
    include("../../../../blocks/err.php");
    include("../../../../blocks/global.php");

    $current_user = intval($_COOKIE["user"]);

    $id_hiking = isset($_GET['id_hiking'])?intval($_GET['id_hiking']):0;
 
    if(!($id_hiking>0)){die(json_encode(array("error"=>"id_hiking is undefined")));}
 
    $z = "
    SELECT
        `hiking_menu_products_replace`.id,
        `hiking_menu_products_replace`.id_source_product,
        `hiking_menu_products_replace`.id_target_product,
        `hiking_menu_products_replace`.rate,
        `hiking_menu_products_replace`.comment,
        `hiking_menu_products_replace`.created_at,
        `hiking_menu_products_replace`.creator_id,
        users.name as creator_name,
        users.surname as creator_surname,
        users.photo_50 as creator_photo,

        src_product.`name` as src_product_name,
        src_product.`protein` as src_product_protein,
        src_product.`fat` as src_product_fat,
        src_product.`carbohydrates` as src_product_carbohydrates,
        src_product.`energy` as src_product_energy,

        tgt_product.`name` as tgt_product_name,
        tgt_product.`protein` as tgt_product_protein,
        tgt_product.`fat` as tgt_product_fat,
        tgt_product.`carbohydrates` as tgt_product_carbohydrates,
        tgt_product.`energy` as tgt_product_energy

    FROM hiking_menu_products_replace
        LEFT JOIN users ON users.id = `hiking_menu_products_replace`.creator_id
        LEFT JOIN recipes_products AS src_product ON src_product.id = `hiking_menu_products_replace`.id_source_product
        LEFT JOIN recipes_products AS tgt_product ON tgt_product.id = `hiking_menu_products_replace`.id_target_product
    WHERE hiking_menu_products_replace.id_hiking={$id_hiking}
    ";
    $q = $mysqli->query($z);
    if(!$q) { die(err($mysqli->error, array("z" => $z)));}

    $res = array();

    while($r = $q->fetch_assoc()){
        $res[] = $r;
    }

    die(out($res));
