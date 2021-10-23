
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_schedule`
--

CREATE TABLE `hiking_schedule` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `d1` datetime NOT NULL,
  `d2` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Борьба с безудержным весельем',
  `id_food_act` int(2) DEFAULT NULL,
  `id_route_object` int(9) DEFAULT NULL,
  `kkal` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_schedule` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_schedule_id_route_object` (`id_route_object`), ADD KEY `fk_hiking_schedule_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_schedule_id_food_act` (`id_food_act`);

ALTER TABLE `hiking_schedule` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_schedule` ADD CONSTRAINT `fk_hiking_schedule_id_food_act` FOREIGN KEY (`id_food_act`) REFERENCES `food_acts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_schedule_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_schedule_id_routeobj` FOREIGN KEY (`id_route_object`) REFERENCES `route_objects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
