
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_menu_saves`
--

CREATE TABLE `hiking_menu_saves` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `id_hiking` int(8) NOT NULL,
  `data` longtext NOT NULL,
  `data_products` text NOT NULL,
  `id_author` int(8) NOT NULL,
  `date` datetime DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `hiking_menu_saves` ADD PRIMARY KEY (`id`), ADD KEY `hiking_menu_saves_fk_hiking` (`id_hiking`), ADD KEY `hiking_menu_saves_fk_author` (`id_author`);

ALTER TABLE `hiking_menu_saves` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_menu_saves` ADD CONSTRAINT `hiking_menu_saves_fk_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `hiking_menu_saves_fk_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
