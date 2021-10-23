
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_equipment`
--

CREATE TABLE `hiking_equipment` (
  `id` int(9) NOT NULL,
  `id_hiking` int(11) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float NOT NULL DEFAULT '0' COMMENT 'вес в кг',
  `value` float NOT NULL DEFAULT '0' COMMENT 'Объём',
  `is_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_author` int(11) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_equipment` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_equipment_id_user` (`id_user`), ADD KEY `fk_hiking_equipment_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_equipment_id_author` (`id_author`);

ALTER TABLE `hiking_equipment` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_equipment` ADD CONSTRAINT `fk_hiking_equipment_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `fk_hiking_equipment_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_equipment_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
