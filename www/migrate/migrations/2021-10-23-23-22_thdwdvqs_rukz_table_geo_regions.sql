
-- --------------------------------------------------------

--
-- Структура таблицы `geo_regions`
--

CREATE TABLE `geo_regions` (
  `id` int(9) NOT NULL,
  `id_country` int(3) NOT NULL,
  `name` varchar(172) NOT NULL,
  `name_r` varchar(128) NOT NULL,
  `subdomain` varchar(64) NOT NULL DEFAULT '',
  `short_subdomain` varchar(6) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `geo_regions` ADD PRIMARY KEY (`id`), ADD KEY `fk_geo_regions_id_country` (`id_country`);

ALTER TABLE `geo_regions` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `geo_regions` ADD CONSTRAINT `fk_geo_regions_id_country` FOREIGN KEY (`id_country`) REFERENCES `geo_countries` (`id`);
