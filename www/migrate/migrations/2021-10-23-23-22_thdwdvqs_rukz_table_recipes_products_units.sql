
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_products_units`
--

CREATE TABLE `recipes_products_units` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(8) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Единицы измерения для продуктов';

ALTER TABLE `recipes_products_units` ADD PRIMARY KEY (`id`);

ALTER TABLE `recipes_products_units` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
