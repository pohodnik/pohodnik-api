
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_workouts_target`
--

CREATE TABLE `hiking_workouts_target` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_author` int(9) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci DEFAULT '',
  `date_start` datetime NOT NULL,
  `date_finish` datetime NOT NULL,
  `distance` int(8) DEFAULT NULL,
  `alt_ascent` int(5) DEFAULT NULL,
  `alt_descent` int(5) DEFAULT NULL,
  `speed_max` int(4) DEFAULT NULL,
  `speed_min` int(4) DEFAULT NULL,
  `speed_avg` int(4) DEFAULT NULL,
  `hr_max` int(3) DEFAULT NULL,
  `hr_min` int(3) DEFAULT NULL,
  `hr_avg` int(3) DEFAULT NULL,
  `time_mooving` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `hiking_workouts_target` ADD PRIMARY KEY (`id`);

ALTER TABLE `hiking_workouts_target` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_workouts_target` ADD CONSTRAINT `fk_hiking_workouts_target_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_workouts_target` ADD CONSTRAINT `fk_hiking_workouts_target_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
