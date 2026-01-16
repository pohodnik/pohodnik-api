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
    iv_qq_type.id AS type_id,
    iv_qq_type.name AS type_name,
    iv_qq_type.is_multi_available AS type_is_multi_available,
    iv_qq_type.hint AS type_hint,
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
    ) AS dir_params,
    GROUP_CONCAT(
        DISTINCT CONCAT_WS(
            'œ',
            IF(
                iv_qq.is_private = 0 OR iv_ans.id_user = @current_user,
                iv_ans_content.`v_from_input`,
                '***'
            ),
            IF(
                iv_qq.is_private = 0 OR iv_ans.id_user = @current_user,
                CONCAT_WS(
                    ',',
                    iv_ans_content.`v_from_variants`
                ),
                0
            ),
            IF(
                iv_qq.is_private = 0 OR iv_ans.id_user = @current_user,
                CONCAT_WS(',', iv_ans_content.`v_from_dir`),
                0
            ),
            IF(
                iv_qq.is_private = 0 OR iv_ans.id_user = @current_user,
                iv_ans_content.`v_custom`,
                '***'
            )
        ) SEPARATOR 'æ'
    ) AS answer,
    iv_ans.date AS answer_date,
    users.id AS user_id,
    users.surname AS user_surname,
    users.name AS user_name,
    users.photo_50 AS user_photo
FROM
    `iv_qq`
LEFT JOIN iv_qq_type ON iv_qq_type.id = iv_qq.id_type
LEFT JOIN iv_qq_params_input ON iv_qq_params_input.id_qq = iv_qq.id
LEFT JOIN iv_qq_params_variants ON iv_qq_params_variants.id_qq = iv_qq.id
LEFT JOIN iv_qq_params_dir ON iv_qq_params_dir.id_qq = iv_qq.id
LEFT JOIN iv_directories ON iv_directories.id = iv_qq_params_dir.id_dir
LEFT JOIN iv_directories_param ON iv_directories_param.id_dir = iv_qq_params_dir.id_dir
LEFT JOIN iv_ans ON iv_ans.id_qq = iv_qq.id
LEFT JOIN iv_ans_content ON iv_ans_content.id_ans = iv_ans.id
LEFT JOIN users ON users.id = iv_ans.id_user
WHERE
    iv_qq.id_iv = @id_iv 
    --@for_current_user AND iv_ans.id_user = @current_user
GROUP BY
    iv_qq.id,
    iv_ans.id,
    iv_ans_content.id_ans
ORDER BY
    iv_qq.order_index