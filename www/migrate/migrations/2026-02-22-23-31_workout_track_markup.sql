CREATE TABLE `workout_track_markup` (
  `id` INT(9) NOT NULL AUTO_INCREMENT ,
  `id_workout_track` INT(9) NOT NULL ,
  `name` VARCHAR(512) NOT NULL ,
  `is_break` BOOLEAN NOT NULL ,
  `date_from` TIMESTAMP NOT NULL COMMENT 'UTC',
  `date_to` TIMESTAMP NOT NULL COMMENT 'UTC',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL ,
  `id_author` INT(9) NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Разметка трека (паузы, участки)';

ALTER TABLE `workout_track_markup`
  ADD KEY `fk_workout_track_markup_id_workout_track` (`id_workout_track`),
  ADD KEY `fk_workout_track_markup_id_author` (`id_author`)
;

ALTER TABLE `workout_track_markup` ADD CONSTRAINT `fkey_workout_track_markup_id_workout_track`
  FOREIGN KEY (`id_workout_track`) REFERENCES `workout_tracks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `workout_track_markup` ADD CONSTRAINT `fkey_workout_track_markup_id_author`
  FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
