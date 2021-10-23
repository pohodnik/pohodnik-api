
-- --------------------------------------------------------

--
-- Структура таблицы `recipes_categories`
--

CREATE TABLE `recipes_categories` (
  `id` int(2) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Категории рецептов';

ALTER TABLE `recipes_categories` ADD PRIMARY KEY (`id`);

ALTER TABLE `recipes_categories` MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
