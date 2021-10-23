
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_editors`
--

CREATE TABLE `hiking_editors` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `is_guide` tinyint(1) NOT NULL DEFAULT '0',
  `is_cook` tinyint(1) NOT NULL DEFAULT '0',
  `is_writter` tinyint(1) NOT NULL DEFAULT '0',
  `is_financier` tinyint(1) NOT NULL DEFAULT '0',
  `is_medic` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_editors` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_editors_id_user` (`id_user`), ADD KEY `fk_hiking_editors_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_editors` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_editors` ADD CONSTRAINT `fk_hiking_editors_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_editors_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
