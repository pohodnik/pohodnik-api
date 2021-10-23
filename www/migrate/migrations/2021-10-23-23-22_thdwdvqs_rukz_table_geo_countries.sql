
-- --------------------------------------------------------

--
-- Структура таблицы `geo_countries`
--

CREATE TABLE `geo_countries` (
  `id` int(3) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Страны';

ALTER TABLE `geo_countries` ADD PRIMARY KEY (`id`);

ALTER TABLE `geo_countries` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
