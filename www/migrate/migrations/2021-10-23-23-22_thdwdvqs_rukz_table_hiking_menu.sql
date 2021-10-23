
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_menu`
--

CREATE TABLE `hiking_menu` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_recipe` int(9) NOT NULL,
  `id_act` int(2) NOT NULL,
  `date` date NOT NULL,
  `is_auto` tinyint(1) NOT NULL DEFAULT '0',
  `is_optimize` tinyint(1) NOT NULL DEFAULT '0',
  `сorrection_coeff_pct` int(3) NOT NULL DEFAULT '100',
  `confirm_date` datetime DEFAULT NULL,
  `confirm_user` int(9) DEFAULT NULL,
  `assignee_user` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Походное меню';

ALTER TABLE `hiking_menu` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_menu_confirm_user` (`confirm_user`), ADD KEY `fk_hiking_menu_id_act` (`id_act`), ADD KEY `fk_hiking_menu_id_recipe` (`id_recipe`), ADD KEY `fk_hiking_menu_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_menu` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_menu` ADD CONSTRAINT `fk_hiking_menu_confirm_user` FOREIGN KEY (`confirm_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_menu_id_act` FOREIGN KEY (`id_act`) REFERENCES `food_acts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_menu_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_menu_id_recipe` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
