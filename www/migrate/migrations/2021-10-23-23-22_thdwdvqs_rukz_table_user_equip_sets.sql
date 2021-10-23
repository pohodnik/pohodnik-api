
-- --------------------------------------------------------

--
-- Структура таблицы `user_equip_sets`
--

CREATE TABLE `user_equip_sets` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_hiking` int(9) DEFAULT NULL,
  `id_backpack` int(9) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Наборы экипы (сборки рюкзаков)';

ALTER TABLE `user_equip_sets` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_user` (`id_user`,`id_hiking`), ADD KEY `fk_user_equip_sets_id_backpack` (`id_backpack`), ADD KEY `fk_user_equip_sets_id_user` (`id_user`), ADD KEY `fk_user_equip_sets_id_hiking` (`id_hiking`);

ALTER TABLE `user_equip_sets` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_equip_sets` ADD CONSTRAINT `fk_user_equip_sets_id_backpack` FOREIGN KEY (`id_backpack`) REFERENCES `user_backpacks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_equip_sets_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_equip_sets_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
