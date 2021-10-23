
-- --------------------------------------------------------

--
-- Структура таблицы `recipes`
--

CREATE TABLE `recipes` (
  `id` int(5) NOT NULL,
  `id_category` int(2) DEFAULT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `cooking_time` int(3) NOT NULL DEFAULT '60' COMMENT 'Время приготовления в минутах',
  `is_light` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'если легкоходненько',
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name_opt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `promo_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `id_author` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='рецепты блюд';

ALTER TABLE `recipes` ADD PRIMARY KEY (`id`), ADD KEY `fk_rrecipes_id_author` (`id_author`), ADD KEY `fk_rrecipes_id_category` (`id_category`);

ALTER TABLE `recipes` MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recipes` ADD CONSTRAINT `fk_rrecipes_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_rrecipes_id_category` FOREIGN KEY (`id_category`) REFERENCES `recipes_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
