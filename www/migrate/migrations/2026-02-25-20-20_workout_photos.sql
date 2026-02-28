CREATE TABLE `workout_photos` (
  `id` int(11) NOT NULL,
  `id_workout` int(11) NOT NULL,
  `url_preview` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `coordinates` point DEFAULT NULL,
  `altitude` int(11) DEFAULT NULL,
  `comment` varchar(512) NOT NULL,
  `is_main` BOOLEAN NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Фотографии тренировок';


ALTER TABLE `workout_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_photos_id_workout` (`id_workout`),
  ADD KEY `workout_photos_creator_id` (`creator_id`);


ALTER TABLE `workout_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `workout_photos`
  ADD CONSTRAINT `fkey_workout_photos_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_workout_photos_id_workout` FOREIGN KEY (`id_workout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
