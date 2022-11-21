CREATE TABLE `workouts_groups` (
  `id` int(9) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `workout_type` int(2) NOT NULL,
  `id_user` int(9) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `workouts_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_workouts_groups_id_user` (`id_user`),
  ADD KEY `fk_workouts_groups_workout_type` (`workout_type`);


ALTER TABLE `workouts_groups`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `workouts_groups`
  ADD CONSTRAINT `fk_workouts_groups_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workouts_groups_workout_type` FOREIGN KEY (`workout_type`) REFERENCES `workout_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE `workouts` ADD `workout_group` INT(9) NULL DEFAULT NULL AFTER `workout_type`;
ALTER TABLE `workouts` ADD CONSTRAINT `fk_workouts_workout_group` FOREIGN KEY (`workout_group`) REFERENCES `workouts_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
