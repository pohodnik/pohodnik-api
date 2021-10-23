
-- --------------------------------------------------------

--
-- Структура таблицы `food_acts_recipe_categories`
--

CREATE TABLE `food_acts_recipe_categories` (
  `id` int(5) NOT NULL,
  `id_food_acts` int(9) NOT NULL,
  `id_recipe_category` int(9) NOT NULL,
  `can_increase` tinyint(1) NOT NULL DEFAULT '0',
  `can_dublicate` tinyint(1) NOT NULL DEFAULT '0',
  `min_pct` int(3) NOT NULL DEFAULT '0',
  `max_pct` int(3) NOT NULL DEFAULT '0',
  `order_index` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `food_acts_recipe_categories` ADD PRIMARY KEY (`id`), ADD KEY `fk_food_acts_recipe_categories_id_food_acts` (`id_food_acts`), ADD KEY `fk_food_acts_recipe_categories_id_recipe_category` (`id_recipe_category`);

ALTER TABLE `food_acts_recipe_categories` MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `food_acts_recipe_categories` ADD CONSTRAINT `fk_food_acts_recipe_categories_id_food_acts` FOREIGN KEY (`id_food_acts`) REFERENCES `food_acts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_food_acts_recipe_categories_id_recipe_category` FOREIGN KEY (`id_recipe_category`) REFERENCES `recipes_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
