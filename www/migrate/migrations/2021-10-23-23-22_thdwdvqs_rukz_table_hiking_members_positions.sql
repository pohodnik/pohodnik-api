
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_members_positions`
--

CREATE TABLE `hiking_members_positions` (
  `id` int(8) NOT NULL,
  `id_hiking` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `id_position` int(3) NOT NULL,
  `id_author` int(8) NOT NULL,
  `date` datetime NOT NULL,
  `comment` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Должности в походе';

ALTER TABLE `hiking_members_positions` ADD PRIMARY KEY (`id`), ADD KEY `hiking_members_positions_fk_hiking` (`id_hiking`), ADD KEY `hiking_members_positions_fk_position` (`id_position`), ADD KEY `hiking_members_positions_fk_user` (`id_user`), ADD KEY `hiking_members_positions_fk_author` (`id_author`);

ALTER TABLE `hiking_members_positions` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_members_positions` ADD CONSTRAINT `hiking_members_positions_fk_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `hiking_members_positions_fk_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_members_positions_fk_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`), ADD CONSTRAINT `hiking_members_positions_fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
