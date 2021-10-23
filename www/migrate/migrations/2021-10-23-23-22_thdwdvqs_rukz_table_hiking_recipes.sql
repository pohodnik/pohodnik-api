
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_recipes`
--

CREATE TABLE `hiking_recipes` (
  `id` int(11) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_recipe` int(9) NOT NULL,
  `id_author` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Рецепты для походов';

ALTER TABLE `hiking_recipes` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_recipes_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_menu_exclude_recipes_id_recipe` (`id_recipe`);

ALTER TABLE `hiking_recipes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_recipes` ADD CONSTRAINT `fk_hiking_menu_exclude_recipes_id_recipe` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_recipes_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
