
-- --------------------------------------------------------

--
-- Структура таблицы `routes`
--

CREATE TABLE `routes` (
  `id` int(5) NOT NULL,
  `id_copySrc` int(9) DEFAULT NULL COMMENT 'Идентификатор маршрута с которого этот скопирован',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `center_coordinates` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '53.132729914996006,45.024418952452734',
  `zoom` int(2) NOT NULL,
  `length` float(9,1) NOT NULL COMMENT 'Длинна в метрах',
  `id_author` int(9) NOT NULL,
  `id_type` int(2) NOT NULL DEFAULT '11',
  `controls` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'контролы через запятую',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `preview_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Маршруты';

ALTER TABLE `routes` ADD PRIMARY KEY (`id`), ADD KEY `fk_routes_id_author` (`id_author`), ADD KEY `fk_routes_id_type` (`id_type`), ADD KEY `fk_routes_id_copysrc` (`id_copySrc`);

ALTER TABLE `routes` MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `routes` ADD CONSTRAINT `fk_routes_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `fk_routes_id_copysrc` FOREIGN KEY (`id_copySrc`) REFERENCES `routes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_routes_id_type` FOREIGN KEY (`id_type`) REFERENCES `route_maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
