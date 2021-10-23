
-- --------------------------------------------------------

--
-- Структура таблицы `user_equip_sets_share`
--

CREATE TABLE `user_equip_sets_share` (
  `id` int(9) NOT NULL,
  `id_set` int(9) NOT NULL,
  `to_user` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Расшаренные сборки рюкзака';

ALTER TABLE `user_equip_sets_share` ADD PRIMARY KEY (`id`), ADD KEY `user_equip_sets_share_id_set` (`id_set`), ADD KEY `user_equip_sets_share_id_user` (`to_user`);

ALTER TABLE `user_equip_sets_share` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_equip_sets_share` ADD CONSTRAINT `user_equip_sets_share_id_set` FOREIGN KEY (`id_set`) REFERENCES `user_equip_sets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `user_equip_sets_share_id_user` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
