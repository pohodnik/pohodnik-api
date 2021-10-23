
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_tracks`
--

CREATE TABLE `hiking_tracks` (
  `id` int(9) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `id_hiking` int(9) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_start` datetime NOT NULL,
  `date_finish` datetime NOT NULL,
  `distance` int(7) NOT NULL DEFAULT '0' COMMENT 'meters',
  `speed_min` int(11) NOT NULL DEFAULT '0' COMMENT 'km/h',
  `speed_max` int(11) NOT NULL DEFAULT '0' COMMENT 'km/h',
  `speed_avg` int(20) NOT NULL DEFAULT '0' COMMENT 'milliseconds per km',
  `alt_min` int(11) NOT NULL DEFAULT '0' COMMENT 'meter',
  `alt_max` int(11) NOT NULL DEFAULT '0' COMMENT 'meter',
  `alt_up_sum` int(11) NOT NULL DEFAULT '0' COMMENT 'meter',
  `alt_down_sum` int(11) NOT NULL DEFAULT '0' COMMENT 'meter',
  `time_in_moution` int(11) NOT NULL DEFAULT '0' COMMENT 'sec'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `hiking_tracks` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_tracks_id_user` (`id_user`), ADD KEY `fk_hiking_tracks_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_tracks` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_tracks` ADD CONSTRAINT `fk_hiking_tracks_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_tracks_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
