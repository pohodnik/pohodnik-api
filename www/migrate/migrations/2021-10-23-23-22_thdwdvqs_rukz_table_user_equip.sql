
-- --------------------------------------------------------

--
-- Структура таблицы `user_equip`
--

CREATE TABLE `user_equip` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(4) NOT NULL,
  `value` double NOT NULL,
  `is_musthave` int(1) NOT NULL DEFAULT '0',
  `is_group` int(1) NOT NULL DEFAULT '0',
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_parent` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Снаряга пользователя';

ALTER TABLE `user_equip` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_equip_user` (`id_user`), ADD KEY `fk_user_equip_category` (`id_category`), ADD KEY `fk_user_equip_parent` (`id_parent`);

ALTER TABLE `user_equip` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_equip` ADD CONSTRAINT `fk_user_equip_category` FOREIGN KEY (`id_category`) REFERENCES `user_equip_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_equip_parent` FOREIGN KEY (`id_parent`) REFERENCES `user_equip` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_equip_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
