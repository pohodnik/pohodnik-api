
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_products_units_values`
--

CREATE TABLE `recipes_products_units_values` (
  `id` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `id_unit` int(5) NOT NULL,
  `weight` int(5) NOT NULL,
  `value` int(5) NOT NULL,
  `cost` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_author` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Продукты в единицах';

ALTER TABLE `recipes_products_units_values` ADD PRIMARY KEY (`id`), ADD KEY `fk_recipes_products_units_values_id_author` (`id_author`), ADD KEY `fk_recipes_products_units_values_id_product` (`id_product`), ADD KEY `fk_recipes_products_units_values_id_unit` (`id_unit`);

ALTER TABLE `recipes_products_units_values` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipes_products_units_values` ADD CONSTRAINT `fk_recipes_products_units_values_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `fk_recipes_products_units_values_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_recipes_products_units_values_id_unit` FOREIGN KEY (`id_unit`) REFERENCES `recipes_products_units` (`id`);
