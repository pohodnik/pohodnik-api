
-- --------------------------------------------------------

--
-- Структура таблицы `route_objects`
--

CREATE TABLE `route_objects` (
  `id` int(9) NOT NULL,
  `id_route` int(9) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `coordinates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `id_typeobject` int(2) NOT NULL DEFAULT '1',
  `icon_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stroke_color` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#006699',
  `stroke_opacity` int(3) NOT NULL DEFAULT '100',
  `stroke_width` int(1) NOT NULL DEFAULT '2',
  `id_creator` int(9) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `id_editor` int(9) DEFAULT NULL,
  `date_last_modif` datetime NOT NULL,
  `distance` int(11) NOT NULL DEFAULT '0' COMMENT 'Дистанция в метрах',
  `is_in_distance` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Учитывать в дистанции',
  `icon_id` int(5) DEFAULT NULL,
  `ord` int(3) NOT NULL DEFAULT '0',
  `is_confirm` tinyint(1) NOT NULL DEFAULT '1',
  `id_mountain_pass` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `route_objects` ADD PRIMARY KEY (`id`), ADD KEY `fk_route_objects_id_creator` (`id_creator`), ADD KEY `fk_route_objects_id_editor` (`id_editor`), ADD KEY `fk_route_objects_id_route` (`icon_id`), ADD KEY `fk_ro_mountain_pass` (`id_mountain_pass`), ADD KEY `fk_route_objects_id_route_fk` (`id_route`);

ALTER TABLE `route_objects` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `route_objects` ADD CONSTRAINT `fk_ro_mountain_pass` FOREIGN KEY (`id_mountain_pass`) REFERENCES `mountain_passes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_objects_id_creator` FOREIGN KEY (`id_creator`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_objects_id_editor` FOREIGN KEY (`id_editor`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_objects_id_route_fk` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
