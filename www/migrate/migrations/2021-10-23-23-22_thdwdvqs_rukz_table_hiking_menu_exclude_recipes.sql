
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_menu_exclude_recipes`
--

CREATE TABLE `hiking_menu_exclude_recipes` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_recipe` int(9) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(9) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Исключаемые рецепты для похода';

ALTER TABLE `hiking_menu_exclude_recipes` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_menu_exclude_recipes_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_menu_exclude_recipes_id_recipe` (`id_recipe`), ADD KEY `fk_hiking_menu_exclude_recipes_id_user` (`id_user`);

ALTER TABLE `hiking_menu_exclude_recipes` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_menu_exclude_recipes` ADD CONSTRAINT `fk_hiking_menu_exclude_recipes_id_hiking_fk` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_menu_exclude_recipes_id_recipe_fk` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`), ADD CONSTRAINT `fk_hiking_menu_exclude_recipes_id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
