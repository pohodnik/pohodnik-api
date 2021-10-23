
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_structure_alt`
--

CREATE TABLE `recipes_structure_alt` (
  `id` int(9) NOT NULL,
  `id_rs` int(9) NOT NULL,
  `id_product` int(5) NOT NULL,
  `amount` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Альтернативы к продуктам в блюдах';

ALTER TABLE `recipes_structure_alt` ADD PRIMARY KEY (`id`), ADD KEY `fk_recipes_structure_alt_id_rs` (`id_rs`), ADD KEY `fk_recipes_structure_alt_id_product` (`id_product`);

ALTER TABLE `recipes_structure_alt` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipes_structure_alt` ADD CONSTRAINT `fk_recipes_structure_alt_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`), ADD CONSTRAINT `fk_recipes_structure_alt_id_rs` FOREIGN KEY (`id_rs`) REFERENCES `recipes_structure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
