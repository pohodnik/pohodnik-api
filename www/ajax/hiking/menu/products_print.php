<?php
	header('Content-type: application/json');
	include("../../../blocks/db.php"); //подключение к БД
	
    $id_hiking = intval($_GET['id_hiking']);
	
	$where = " hiking_menu.id_hiking={$id_hiking} ";
	
	if(isset($_GET['id_user'])){
		$where .= " AND  hiking_menu.assignee_user=".intval($_GET['id_user']);
	}
	
	if(isset($_GET['date'])){
		$where .= " AND  hiking_menu.date='".intval($_GET['date'])."'";
	}	

	if(isset($_GET['id_product'])){
        $id_product = intval($_GET['id_product']);
		$productWhere = " AND recipes_products.id={$id_product}";
        $repl_q = $mysqli -> query("SELECT id_target_product FROM hiking_menu_products_replace WHERE id_source_product = {$id_product}");
        if(!$repl_q){die(json_encode(array("error"=>$mysqli->error)));}

        if ($repl_q->num_rows) {
            $productWhere = " AND recipes_products.id IN({$id_product}, {$repl_q->fetch_row()[0]})";
        }

        $where .= $productWhere;
    }
	

   /// die($where);
$z = "
SELECT 

	food_acts.name AS food_act_name,
	".(isset($_GET['id_product'])?'1':'0')." AS is_one,
	NOT ISNULL( forseuser.id ) AS is_force,
	recipes.name AS recipe_name,
	hiking_schedule.d1,

    IFNULL(forseuser.name,users.name) AS uname,
	IFNULL(forseuser.surname, users.surname) AS usurname,
	IFNULL(forseuser.photo_50, users.photo_50) AS uphoto,
	IFNULL(forseuser.id, users.id) AS uid,

    recipes_products.id as original_id_product,
    recipes_products.name as original_name,
    hiking_menu_products_replace.rate as replace_rate,

    IFNULL(replace_product.name, recipes_products.name) as name,
    IFNULL(replace_product.id, recipes_products.id) AS id_product,

    (recipes_structure.amount*(hiking_menu.сorrection_coeff_pct/100)) * IFNULL(hiking_menu_products_replace.rate, 1) AS amount,

	(IFNULL(replace_product.protein, recipes_products.protein)/100) AS protein_per_gram,
	(IFNULL(replace_product.carbohydrates, recipes_products.carbohydrates)/100) AS carbohydrates_per_gram,
	(IFNULL(replace_product.fat, recipes_products.fat)/100) AS fat_per_gram,
	(IFNULL(replace_product.energy, recipes_products.energy)/100) AS energy_per_gram,
    
	UNIX_TIMESTAMP(hiking_schedule.d1) AS uts,
0 as is_optimize
    FROM hiking_menu
	LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe 
	LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
	LEFT JOIN recipes_products ON recipes_structure.id_product = recipes_products.id
    LEFT JOIN hiking_menu_products_replace ON hiking_menu_products_replace.id_source_product = recipes_products.id
    LEFT JOIN recipes_products AS replace_product ON replace_product.id = `hiking_menu_products_replace`.id_target_product
	LEFT JOIN hiking_schedule ON (hiking_schedule.id_food_act = hiking_menu.id_act AND hiking_menu.id_hiking =hiking_schedule.id_hiking AND DAY(hiking_schedule.d1)=DAY(hiking_menu.date))
	LEFT JOIN food_acts  ON hiking_menu.id_act = food_acts.id
	LEFT JOIN users ON hiking_menu.assignee_user = users.id
	LEFT JOIN hiking_menu_products_force ON (hiking_menu.id_hiking = hiking_menu_products_force.id_hiking AND hiking_menu_products_force.id_product = recipes_products.id)
	LEFT JOIN users AS forseuser ON forseuser.id = hiking_menu_products_force.id_user

WHERE {$where} ORDER BY recipes_products.name, hiking_schedule.d1, recipes.id
";

$q = $mysqli->query($z);

if(!$q){die(json_encode(array("error"=>$mysqli->error)));}

$res = array();

while($r = $q->fetch_assoc()){
	$r['date_rus'] = date('d.m.y', $r['uts']);
	$r['time_rus'] = date('H:i', $r['uts']);

    $r['protein'] = $r['protein_per_gram'] * $r['amount'];
    $r['carbohydrates'] = $r['carbohydrates_per_gram'] * $r['amount'];
    $r['fat'] = $r['fat_per_gram'] * $r['amount'];
    $r['energy'] = $r['energy_per_gram'] * $r['amount'];

	$res[] = $r;
}

echo (json_encode($res));
