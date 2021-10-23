
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_radish`
--

CREATE TABLE `hiking_radish` (
  `id` int(11) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `killer` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Отказавшиеся от похода';

ALTER TABLE `hiking_radish` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_radish_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_radish_id_user` (`id_user`);

ALTER TABLE `hiking_radish` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_radish` ADD CONSTRAINT `fk_hiking_radish_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_radish_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
