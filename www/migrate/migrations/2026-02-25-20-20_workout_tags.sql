CREATE TABLE `workout_tags` (
  `id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(6) NOT NULL,
  `is_personal` BOOLEAN NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Теги тренировок';


ALTER TABLE `workout_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_tags_creator_id` (`creator_id`);


ALTER TABLE `workout_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `workout_tags`
  ADD CONSTRAINT `fkey_workout_tags_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;


CREATE TABLE `workout_tags_usages` (
  `id` int(11) NOT NULL,
  `id_workout` int(11) NOT NULL,
  `id_workout_tag` int(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Теги тренировок';

ALTER TABLE `workout_tags_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_tags_usages_id_workout` (`id_workout`),
  ADD KEY `workout_tags_usages_id_workout_tag` (`id_workout_tag`);


ALTER TABLE `workout_tags_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `workout_tags_usages`
  ADD CONSTRAINT `fkey_workout_tags_usages_id_workout` FOREIGN KEY (`id_workout`) REFERENCES `workouts` (`id`)  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_workout_tags_usages_id_workout_tag` FOREIGN KEY (`id_workout_tag`) REFERENCES `workout_tags` (`id`)  ON DELETE CASCADE ON UPDATE CASCADE
  ;
