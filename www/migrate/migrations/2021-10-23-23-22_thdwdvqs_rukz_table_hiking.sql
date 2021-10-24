
-- --------------------------------------------------------

--
-- Структура таблицы `hiking`
--

CREATE TABLE `hiking` (
  `id` int(11) NOT NULL,
  `id_type` int(3) DEFAULT NULL,
  `id_route` int(9) DEFAULT NULL,
  `is_vacant_route` int(1) NOT NULL DEFAULT '0' COMMENT 'разрешить предлагать маршруты',
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `color` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#6f5499',
  `id_author` int(9) NOT NULL COMMENT 'Создатель',
  `confirm_list_products` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_list_date` datetime DEFAULT NULL,
  `confirm_list_user` int(9) DEFAULT NULL,
  `bg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ava` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vk_group_id` int(11) DEFAULT  NULL,
  `menu_optimize` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_region` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_id_author` (`id_author`), ADD KEY `fk_hiking_id_route` (`id_route`), ADD KEY `fk_hiking_id_type` (`id_type`), ADD KEY `fk_hiking_id_region` (`id_region`);

ALTER TABLE `hiking` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking` ADD CONSTRAINT `fk_hiking_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_id_region` FOREIGN KEY (`id_region`) REFERENCES `geo_regions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_id_type` FOREIGN KEY (`id_type`) REFERENCES `hiking_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
