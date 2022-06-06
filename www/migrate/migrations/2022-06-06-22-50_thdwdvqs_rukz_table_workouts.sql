
-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `workouts` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci DEFAULT '',
  `trackdata` text COLLATE utf8_unicode_ci NOT NULL,
  `trackmeta` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` datetime NOT NULL,
  `date_finish` datetime NOT NULL,
  `date_upload` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `activity_type` varchar(96) COLLATE utf8_unicode_ci DEFAULT '',
  `distance` int(8) NOT NULL,
  `alt_ascent` int(5) NOT NULL,
  `alt_descent` int(5) NOT NULL,
  `alt_max` int(4) NOT NULL,
  `alt_min` int(4) NOT NULL,
  `alt_avg` int(4) NOT NULL,
  `speed_max` int(4) NOT NULL,
  `speed_min` int(4) NOT NULL,
  `speed_avg` int(4) NOT NULL,
  `hr_max` int(3) DEFAULT NULL,
  `hr_min` int(3) DEFAULT NULL,
  `hr_avg` int(3) DEFAULT NULL,
  `temp_max` int(2) DEFAULT NULL,
  `temp_min` int(2) DEFAULT NULL,
  `temp_avg` int(2) DEFAULT NULL,
  `time_mooving` int(8) NOT NULL,
  `time_pause` int(8) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `workouts` ADD PRIMARY KEY (`id`);

ALTER TABLE `workouts` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `workouts` ADD CONSTRAINT `fk_workouts_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
