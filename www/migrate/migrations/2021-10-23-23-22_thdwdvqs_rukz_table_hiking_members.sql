
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_members`
--

CREATE TABLE `hiking_members` (
  `id` int(11) NOT NULL,
  `id_hiking` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_members` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_members_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_members_id_user` (`id_user`);

ALTER TABLE `hiking_members` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_members` ADD CONSTRAINT `fk_hiking_members_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_members_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
