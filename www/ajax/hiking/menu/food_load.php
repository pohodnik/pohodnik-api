<?php
header('Content-type: application/json');
include("../../../blocks/db.php"); //подключение к БД
include("../../../blocks/for_auth.php"); //Только для авторизованных
$res = array();
$id_hiking = intval($_GET['id_hiking']);

$addwhere = "";

if(isset($_GET['id_act'])){$addwhere .= " AND hiking_menu.id_act=".intval($_GET['id_act'])." ";}
if(isset($_GET['date'])){$addwhere .= " AND hiking_menu.date='".$mysqli->real_escape_string($_GET['date'])."' ";}

$q = $mysqli->query("
SELECT 
    recipes.*,
    hiking_menu.*,
    CONCAT(users.name,' ',users.surname) AS uname,
    users.photo_50 AS uphoto,
    users.id AS uid,

    SUM((IFNULL(replace_product.protein, recipes_products.protein) / 100) * recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1)) AS protein,
    SUM((IFNULL(replace_product.fat, recipes_products.fat) / 100) * recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1)) AS fat,
    SUM((IFNULL(replace_product.carbohydrates, recipes_products.carbohydrates) / 100) * recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1)) AS carbohydrates,
    SUM((IFNULL(replace_product.energy, recipes_products.energy) / 100) * recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1)) AS energy,
    SUM(recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1)) AS amount,
    
    GROUP_CONCAT(
        CONCAT_WS('|',
            IFNULL(replace_product.id, recipes_structure.id_product),
            IFNULL(replace_product.name, recipes_products.name),
            recipes_structure.amount * IFNULL(hiking_menu_products_replace.rate, 1),
            recipes_products.id,
            recipes_products.name,
            hiking_menu_products_replace.rate

        )
        SEPARATOR '&'
    ) AS products
FROM hiking_menu
    LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe 
    LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
    LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
    LEFT JOIN users ON hiking_menu.assignee_user = users.id


    LEFT JOIN hiking_menu_products_replace ON hiking_menu_products_replace.id_source_product = recipes_structure.id_product
    LEFT JOIN recipes_products AS replace_product ON replace_product.id = `hiking_menu_products_replace`.id_target_product


WHERE hiking_menu.id_hiking={$id_hiking} ".$addwhere."
GROUP BY  hiking_menu.id_recipe, hiking_menu.id_act, hiking_menu.date
");

if(!$q){die(json_encode(array("error"=>$mysqli->error)));}

while($r = $q->fetch_assoc()){
  $res[] = $r;
}

exit(json_encode($res));
