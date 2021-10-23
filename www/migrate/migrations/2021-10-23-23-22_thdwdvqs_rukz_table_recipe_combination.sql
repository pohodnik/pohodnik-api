
-- --------------------------------------------------------

--
-- Структура таблицы `recipe_combination`
--

CREATE TABLE `recipe_combination` (
  `id` int(8) NOT NULL,
  `id_recipe` int(8) NOT NULL,
  `id_recipe2` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='С чем рецепт сочетается';

ALTER TABLE `recipe_combination` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_recipe` (`id_recipe`,`id_recipe2`), ADD KEY `recipe_combination_fk_recipe_2` (`id_recipe2`);

ALTER TABLE `recipe_combination` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipe_combination` ADD CONSTRAINT `recipe_combination_fk_recipe_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `recipe_combination_fk_recipe_2` FOREIGN KEY (`id_recipe2`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
