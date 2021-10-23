
-- --------------------------------------------------------

--
-- Структура таблицы `route_regions`
--

CREATE TABLE `route_regions` (
  `id` int(11) NOT NULL,
  `id_route` int(11) NOT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `route_regions` ADD PRIMARY KEY (`id`), ADD KEY `fk_route_regions_id_route9` (`id_route`), ADD KEY `fk_route_regions_id_region9` (`id_region`);

ALTER TABLE `route_regions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `route_regions` ADD CONSTRAINT `fk_route_regions_id_region` FOREIGN KEY (`id_region`) REFERENCES `geo_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_regions_id_region9` FOREIGN KEY (`id_region`) REFERENCES `geo_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_regions_id_route` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_regions_id_route9` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
