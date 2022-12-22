<?php
	include('../../../blocks/db.php');
	// include("../../../blocks/err.php");
    include('../../../blocks/sql.php');
	include("../../../blocks/global.php");

    $ids_hiking = explode(',', $mysqli->real_escape_string($_GET['hiking_ids']));

    $q = $mysqli->query("SELECT
    recipes_products.name,
    SUM(recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100)) AS amount,
    SUM(recipes_products.protein/100*recipes_structure.amount) AS protein, 
			SUM(recipes_products.fat/100*recipes_structure.amount) AS fat, 
			SUM(recipes_products.carbohydrates/100*recipes_structure.amount) AS carbohydrates, 
			SUM(recipes_products.energy/100*recipes_structure.amount) AS energy, 
    recipes_products.id AS id,
    GROUP_CONCAT(
        DISTINCT
      CONCAT_WS(
        'œ',
        recipes.name,
        hiking_menu.date,
        recipes_structure.amount * (hiking_menu.сorrection_coeff_pct / 100),
        food_acts.name,
        recipes_categories.name
      ) SEPARATOR '→'
    ) AS usages
  FROM hiking_menu
  LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe
  LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
  LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
  LEFT JOIN recipes_categories ON  recipes.id_category = recipes_categories.id
  LEFT JOIN food_acts ON  food_acts.id = hiking_menu.id_act
WHERE hiking_menu.id_hiking IN(".implode(',',$ids_hiking).")
GROUP BY id_product  
ORDER BY `amount` DESC;");
    if (!$q) { die(err('Error update', array('message' => $mysqli->error, 'sql' => $sql, 'file'=>$file))); }
    $result = array();

    while ($r = $q -> fetch_assoc()) {
        $r['usages'] = array_map(function ($a) {
            $x = explode('œ', $a);
            return array(
                "name" => $x[0],
                "date" => $x[1],
                "amount" => $x[2],
                "act" => $x[3],
                "category" => $x[4]
            );}, explode('→', $r['usages']));
         $result[] = $r;
    }

    die(jout($result));

?>