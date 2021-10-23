
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_structure`
--

CREATE TABLE `recipes_structure` (
  `id` int(9) NOT NULL,
  `id_recipe` int(5) NOT NULL,
  `id_product` int(6) NOT NULL,
  `amount` float(5,2) NOT NULL COMMENT 'кол-во продуктов в граммах'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `recipes_structure` ADD PRIMARY KEY (`id`), ADD KEY `fk_recipes_structure_id_recipe` (`id_recipe`), ADD KEY `fk_recipes_structure_id_product` (`id_product`);

ALTER TABLE `recipes_structure` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipes_structure` ADD CONSTRAINT `fk_recipes_structure_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`) ON UPDATE CASCADE, ADD CONSTRAINT `fk_recipes_structure_id_recipe` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
