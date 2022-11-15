START TRANSACTION;

CREATE TABLE `workouts` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) DEFAULT '',
  `workout_type` int(2) DEFAULT NULL,
  `id_workout_track` int(9) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_workouts_id_user` (`id_user`),
  ADD KEY `fk_workouts_workout_type` (`workout_type`),
  ADD KEY `fk_workouts_id_workout_track` (`id_workout_track`);

ALTER TABLE `workouts`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `workouts`
  ADD CONSTRAINT `fk_workouts_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workouts_workout_type` FOREIGN KEY (`workout_type`) REFERENCES `workout_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workouts_id_workout_track` FOREIGN KEY (`id_workout_track`) REFERENCES `workout_tracks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
  


INSERT INTO `workouts`(`id_user`, `name`, `description`, `workout_type`, `id_workout_track`, `date_create`, `date_update`) SELECT `id_user`, `name`, `description`, `workout_type`, `id`, `date_upload`, `date_update` FROM workout_tracks;

ALTER TABLE thdwdvqs_rukz.workout_tracks DROP FOREIGN KEY fk_workouts_workout_type;
ALTER TABLE `workout_tracks` DROP INDEX `fk_workouts_workout_type`;
ALTER TABLE `workout_tracks`
  DROP `name`,
  DROP `description`,
  DROP `workout_type`;
  
ALTER TABLE `hiking_tracks`
  DROP `url`,
  DROP `date_start`,
  DROP `date_finish`,
  DROP `distance`,
  DROP `speed_min`,
  DROP `speed_max`,
  DROP `speed_avg`,
  DROP `alt_min`,
  DROP `alt_max`,
  DROP `alt_up_sum`,
  DROP `alt_down_sum`,
  DROP `time_in_moution`;

COMMIT;
