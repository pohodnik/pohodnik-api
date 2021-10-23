
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_route_variants`
--

CREATE TABLE `hiking_route_variants` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_route` int(9) NOT NULL,
  `id_author` int(9) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `hiking_route_variants` ADD PRIMARY KEY (`id`), ADD KEY `hiking_route_variants_fk_route` (`id_route`), ADD KEY `hiking_route_variants_fk_hiking` (`id_hiking`), ADD KEY `hiking_route_variants_fk_author` (`id_author`);

ALTER TABLE `hiking_route_variants` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_route_variants` ADD CONSTRAINT `hiking_route_variants_fk_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_route_variants_fk_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_route_variants_fk_route` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
