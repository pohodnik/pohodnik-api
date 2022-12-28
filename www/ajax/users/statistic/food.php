<?php
	include('../../../blocks/db.php');
  include('../../../blocks/sql.php');
	include("../../../blocks/global.php");

    $id_user = intval($_GET['id_user']);
    $year = intval($_GET['year']);

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
  FROM hiking
  LEFT JOIN hiking_members ON (hiking_members.id_hiking = hiking.id)
  LEFT JOIN hiking_schedule ON (
    hiking_schedule.id_hiking = hiking_members.id_hiking
    AND (
      hiking_schedule.d1 BETWEEN IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start)
      AND IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish)
    ) AND (
      hiking_schedule.d2 BETWEEN IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start)
      AND IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish)
    )
  )
  LEFT JOIN hiking_menu ON (
    hiking_schedule.id_hiking = hiking_menu.id_hiking
    AND DATE(hiking_schedule.d1) = DATE(hiking_menu.date)
    AND hiking_schedule.id_food_act = hiking_menu.id_act
  )
  LEFT JOIN recipes ON recipes.id = hiking_menu.id_recipe
  LEFT JOIN recipes_structure ON recipes_structure.id_recipe = recipes.id
  LEFT JOIN recipes_products ON  recipes_structure.id_product = recipes_products.id
  LEFT JOIN recipes_categories ON  recipes.id_category = recipes_categories.id
  LEFT JOIN food_acts ON  food_acts.id = hiking_menu.id_act
WHERE
  hiking_members.id_user = {$id_user} AND YEAR(hiking.start) = {$year}
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