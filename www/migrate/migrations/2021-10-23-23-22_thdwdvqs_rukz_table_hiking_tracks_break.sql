
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_tracks_break`
--

CREATE TABLE `hiking_tracks_break` (
  `id` int(9) NOT NULL,
  `id_track` int(9) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `from_point` varchar(64) NOT NULL,
  `from_time` int(11) NOT NULL,
  `to_point` varchar(64) NOT NULL,
  `to_time` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `id_author` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Привалы на треках';

ALTER TABLE `hiking_tracks_break` ADD PRIMARY KEY (`id`), ADD KEY `hiking_tracks_break_track_id_fk` (`id_track`), ADD KEY `hiking_tracks_break_author_id_fk` (`id_author`);

ALTER TABLE `hiking_tracks_break` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_tracks_break` ADD CONSTRAINT `hiking_tracks_break_author_id_fk` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `hiking_tracks_break_track_id_fk` FOREIGN KEY (`id_track`) REFERENCES `hiking_tracks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
