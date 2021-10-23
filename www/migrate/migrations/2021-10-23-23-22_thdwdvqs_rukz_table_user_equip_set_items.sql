
-- --------------------------------------------------------

--
-- Структура таблицы `user_equip_set_items`
--

CREATE TABLE `user_equip_set_items` (
  `id` int(9) NOT NULL,
  `id_set` int(9) NOT NULL,
  `amount` int(2) NOT NULL DEFAULT '1',
  `id_equip` int(9) NOT NULL,
  `is_check` int(1) NOT NULL DEFAULT '0',
  `date_confirm` datetime DEFAULT NULL,
  `user_confirm` int(8) DEFAULT NULL,
  `from_user` int(8) DEFAULT NULL COMMENT 'Если переназначено'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `user_equip_set_items` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_set` (`id_set`,`id_equip`), ADD UNIQUE KEY `Уникально` (`id_set`,`id_equip`), ADD KEY `fk_user_equip_set_items_id_set` (`id_set`), ADD KEY `fk_user_equip_set_items_id_equip` (`id_equip`);

ALTER TABLE `user_equip_set_items` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_equip_set_items` ADD CONSTRAINT `fk_user_equip_set_items_id_equip` FOREIGN KEY (`id_equip`) REFERENCES `user_equip` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_equip_set_items_id_set` FOREIGN KEY (`id_set`) REFERENCES `user_equip_sets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
