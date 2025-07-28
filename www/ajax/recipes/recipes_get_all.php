<?php
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/global.php"); //подключение к БД
include("../../blocks/err.php"); //подключение к БД
$result=array();$id_act = 0;$id_category = 0; $for_hiking = 0;
if(isset($_GET['id_act']) && $_GET['id_act']>0){$id_act=intval($_GET['id_act']);}
if(isset($_GET['id_category']) && $_GET['id_category']>0){$id_category=intval($_GET['id_category']);}
if(isset($_GET['exclude_ids'])){
    $exclude_ids = is_array($_GET['exclude_ids']) ? $_GET['exclude_ids'] : array($_GET['exclude_ids']);
}
if(isset($_GET['for_hiking']) && intval($_GET['for_hiking'])>0){$for_hiking=intval($_GET['for_hiking']);}

$add_j = "";
$add_q = "";
 if($id_act>0){
	$add_j = " LEFT JOIN food_acts_recipe_categories ON food_acts_recipe_categories.id_recipe_category = recipes_categories.id ";
	$add_q .= " AND  food_acts_recipe_categories.id_food_acts={$id_act} ";
}


if($id_category>0){
	$add_q .= " AND  recipes_categories.id={$id_category} ";
}


$q = $mysqli->query("SELECT recipes_categories.id, recipes_categories.name FROM recipes_categories {$add_j} WHERE recipes_categories.id>0 {$add_q}");
if(!$q){exit(json_encode(array("error"=>"Ошибка при запросе категорий. \r\n".$mysqli->error)));}
$id_user = isset($_COOKIE["user"]) ? $_COOKIE["user"] : 0;


while($r = $q->fetch_assoc()){
$r["items"] = array();

$claus = "";
$joins = "";

if(isset($exclude_ids) && count($exclude_ids)>0){

	$claus .= " AND  recipes.id NOT IN(".implode(',',$exclude_ids).") ";
}

if($for_hiking>0){
	$joins .= " LEFT JOIN hiking_recipes ON hiking_recipes.id_recipe = recipes.id ";
	$claus .= " AND hiking_recipes.id_hiking={$for_hiking}";
} 

	$q2 = $mysqli->query("
    SELECT 
        recipes.id, recipes.name, recipes.photo, recipes.promo_text, recipes.id_author, (recipes.id_author=".$id_user.") AS my ,
        SUM((recipes_products.protein/100)*recipes_structure.amount) AS protein,
        SUM((recipes_products.fat/100)*recipes_structure.amount) AS fat,
        SUM((recipes_products.carbohydrates/100)*recipes_structure.amount) AS carbohydrates,
        SUM((recipes_products.energy/100)*recipes_structure.amount) AS energy,
        SUM(recipes_structure.amount) as amount
    FROM recipes 
        LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
        LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
        {$joins}
    WHERE recipes.id_category=".$r['id']." {$claus} GROUP BY recipes.id
    ");
	if(!$q2){die($mysqli->error);}
	while($r2 = $q2->fetch_assoc()){
		$r["items"][] = $r2;
	}
	$result[] = $r;		
}

exit(json_encode($result));
?>
