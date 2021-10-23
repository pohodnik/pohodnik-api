
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_products_alt`
--

CREATE TABLE `recipes_products_alt` (
  `id` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `id_alt` int(9) NOT NULL,
  `weight` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Альтернативы для продуктов';

ALTER TABLE `recipes_products_alt` ADD PRIMARY KEY (`id`), ADD KEY `fk_recipes_products_alt_id_product` (`id_product`), ADD KEY `fk_recipes_products_alt_id_alt` (`id_alt`);

ALTER TABLE `recipes_products_alt` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipes_products_alt` ADD CONSTRAINT `fk_recipes_products_alt_id_alt` FOREIGN KEY (`id_alt`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_recipes_products_alt_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
