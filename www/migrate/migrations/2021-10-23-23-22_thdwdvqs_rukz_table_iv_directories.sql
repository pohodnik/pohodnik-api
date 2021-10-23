
-- --------------------------------------------------------

--
-- Структура таблицы `iv_directories`
--

CREATE TABLE `iv_directories` (
  `id` int(3) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `table` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Справочники для опросов';

ALTER TABLE `iv_directories` ADD PRIMARY KEY (`id`);

ALTER TABLE `iv_directories` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
