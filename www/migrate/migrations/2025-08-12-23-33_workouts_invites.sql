
CREATE TABLE `workout_invites` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_workout` INT(11) NOT NULL ,
  `id_user` INT(9) NOT NULL ,
  `id_author` INT(9) NOT NULL ,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted_at` DATETIME NULL DEFAULT NULL ,
  `rejected_at` DATETIME NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Приглашения в тренировку';

ALTER TABLE `workout_invites`
  ADD KEY `fk_workout_invites_id_workout` (`id_workout`),
  ADD KEY `fk_workout_invites_id_user` (`id_user`),
  ADD KEY `fk_workout_invites_id_author` (`id_author`)
;

ALTER TABLE `workout_invites` ADD CONSTRAINT `fkey_fk_workout_invites_id_workout` FOREIGN KEY (`id_workout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `workout_invites` ADD CONSTRAINT `fkey_fk_workout_invites_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `workout_invites` ADD CONSTRAINT `fkey_fk_workout_invites_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
