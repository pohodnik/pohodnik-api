
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_types`
--

CREATE TABLE `hiking_types` (
  `id` int(3) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_types` ADD PRIMARY KEY (`id`);

ALTER TABLE `hiking_types` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
