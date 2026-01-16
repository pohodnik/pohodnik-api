<?php
header('Content-type: application/json');
include("../../blocks/db.php"); //подключение к БД
include("../../blocks/for_auth.php"); //Только для авторизованных
include("../../blocks/global.php"); //Только для авторизованных
$result = array();
$id = intval($_GET['id']);
$id_user = intval($_COOKIE["user"]);

$z = "
SELECT
    iv_qq.id,
    iv_qq.id_iv,
    iv_qq.name,
    iv_qq.text,
    iv_qq.id_type,
    iv_qq.is_custom,
    iv_qq.is_require,
    iv_qq.is_multi,
    iv_qq.is_private,
    iv_qq.order_index,

    iv_qq_type.id as type_id,
    iv_qq_type.name as type_name,
    iv_qq_type.is_multi_available as type_is_multi_available,
    iv_qq_type.hint as type_hint,

    CONCAT_WS(
        'œ',
        iv_qq_params_input.id,
        iv_qq_params_input.type,
        iv_qq_params_input.pattern,
        iv_qq_params_input.placeholder,
        iv_qq_params_input.min,
        iv_qq_params_input.max,
        iv_qq_params_input.step
    ) AS params,

	GROUP_CONCAT(
        DISTINCT CONCAT_WS(
		    'œ',
            iv_qq_params_variants.id,
            iv_qq_params_variants.value, 
            iv_qq_params_variants.order_index
        ) SEPARATOR 'æ'
    ) AS variants,


    CONCAT_WS(
        'œ',
        iv_qq_params_dir.id,
        iv_qq_params_dir.id_dir,
        iv_directories.name,
        iv_directories.desc,
        iv_directories.table, 
        iv_directories_param.name,
        iv_directories_param.value,
        iv_directories_param.is_equall
    ) AS dir_params
FROM
    `iv_qq`
    LEFT JOIN iv_qq_type ON iv_qq_type.id = iv_qq.id_type
    LEFT JOIN iv_qq_params_input ON iv_qq_params_input.id_qq = iv_qq.id
    LEFT JOIN iv_qq_params_variants ON iv_qq_params_variants.id_qq = iv_qq.id
    LEFT JOIN iv_qq_params_dir ON iv_qq_params_dir.id_qq = iv_qq.id
	LEFT JOIN iv_directories ON iv_directories.id = iv_qq_params_dir.id_dir
    LEFT JOIN iv_directories_param ON iv_directories_param.id_dir=iv_qq_params_dir.id_dir
WHERE
   iv_qq.id_iv={$id}
GROUP BY iv_qq.id
ORDER BY iv_qq.order_index
";

$qb = $mysqli->query($z);
if(!$qb) die(jout(err($mysqli->error, array("z" => $z))));

function variant($var_str)
{
    return explode('œ', $var_str);
}

while($r=$qb->fetch_assoc()){
    if (!empty($r['params'])) {$r['params'] = explode('œ', $r['params']);} else {$r['params'] = null;}
    if (!empty($r['dir_params'])) {$r['dir_params'] = explode('œ', $r['dir_params']);} else {$r['dir_params'] = null;}
    if (!empty($r['variants'])) {$r['variants'] =  array_map('variant', explode('æ', $r['variants']));} else  {$r['variants']=null;}
    
    $result[] = $r;
}
    
	
echo jout($result);

?>
