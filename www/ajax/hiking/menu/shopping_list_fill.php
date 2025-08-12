<?php
include("../../../blocks/db.php");
include("../../../blocks/for_auth.php");
include("../../../blocks/err.php");
$result = array();
$id_user = $_COOKIE["user"];
$id_hiking = isset($_POST['id_hiking']) ? intval($_POST['id_hiking']) : 0;

$q = $mysqli->query("
    SELECT id FROM
        `hiking_menu_shopping`
    WHERE 
        `id_hiking`={$id_hiking} AND `is_complete`=1
    LIMIT 1
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}
if($q -> num_rows == 1){die(json_encode(array('error'=>"has completed items")));} else {
$q = $mysqli->query("
    DELETE FROM       
        `hiking_menu_shopping`
    WHERE 
        `id_hiking`={$id_hiking} AND `is_complete`=0
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}
}


$q = $mysqli->query("SET SESSION group_concat_max_len=999999;");
$q = $mysqli->query("
    INSERT INTO
        `hiking_menu_shopping`
        (`id_hiking`, `id_product`, `need_amount`, `usages`)
    SELECT
        hiking_menu.id_hiking,

        IFNULL(replace_product.id, recipes_products.id) AS id_product,

        ROUND(SUM(recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100)  * IFNULL(hiking_menu_products_replace.rate, 1)),2) AS need_amount,
        GROUP_CONCAT(
            CONCAT_WS(
                '|',
                recipes.name,
                hiking_menu.date,
                ROUND(recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100) * IFNULL(hiking_menu_products_replace.rate, 1),2)
            )
        ) AS usages
    FROM hiking_menu
        LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe 
        LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
        LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
            LEFT JOIN hiking_menu_products_replace ON hiking_menu_products_replace.id_source_product = recipes_structure.id_product
    LEFT JOIN recipes_products AS replace_product ON replace_product.id = `hiking_menu_products_replace`.id_target_product

    WHERE hiking_menu.id_hiking={$id_hiking}
    GROUP BY IFNULL(replace_product.id, recipes_products.id)
");
if(!$q){die(json_encode(array('error'=>$mysqli->error)));}
die(json_encode(array('success' => true, 'affected' => $mysqli -> affected_rows)));
