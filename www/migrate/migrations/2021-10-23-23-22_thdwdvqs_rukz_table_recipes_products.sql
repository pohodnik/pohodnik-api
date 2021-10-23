
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_products`
--

CREATE TABLE `recipes_products` (
  `id` int(9) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `protein` float NOT NULL COMMENT 'белки',
  `fat` float NOT NULL COMMENT 'жиры',
  `carbohydrates` float NOT NULL COMMENT 'Углдеводы',
  `energy` int(6) NOT NULL COMMENT 'ККАЛ',
  `weight` int(5) NOT NULL COMMENT 'Вес в граммах',
  `cost` float(3,2) NOT NULL COMMENT 'Стоимость в рублях'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `recipes_products` ADD PRIMARY KEY (`id`);

ALTER TABLE `recipes_products` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
