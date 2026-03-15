ALTER TABLE `hiking_workouts_target` CHANGE `id_hiking` `id_hiking` INT(11) NULL;
RENAME TABLE `hiking_workouts_target` TO `workout_targets`;

ALTER TABLE `workout_targets` ADD `is_public` BOOLEAN NOT NULL DEFAULT FALSE AFTER `id_hiking`;

CREATE TABLE `workout_target_members` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_workout_target` INT(11) NOT NULL ,
  `id_user` INT(9) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `workout_target_members`
  ADD KEY `fk_workout_target_members_id_workout_target` (`id_workout_target`),
  ADD KEY `fk_workout_target_members_id_user` (`id_user`)
;

ALTER TABLE `workout_target_members` ADD CONSTRAINT `fkey_fk_workout_target_members_id_workout_target` FOREIGN KEY (`id_workout_target`) REFERENCES `workout_targets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `workout_target_members` ADD CONSTRAINT `fkey_fk_workout_target_members_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `workout_target_invites` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_workout_target` INT(11) NOT NULL ,
  `id_user` INT(9) NOT NULL ,
  `id_author` INT(9) NOT NULL ,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted_at` DATETIME NULL DEFAULT NULL ,
  `rejected_at` DATETIME NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Приглашения в план тренировок';

ALTER TABLE `workout_target_invites`
  ADD KEY `fk_workout_target_invites_id_workout_target` (`id_workout_target`),
  ADD KEY `fk_workout_target_invites_id_user` (`id_user`),
  ADD KEY `fk_workout_target_invites_id_author` (`id_author`)
;

ALTER TABLE `workout_target_invites` ADD CONSTRAINT `fkey_fk_workout_target_invites_id_workout_target` FOREIGN KEY (`id_workout_target`) REFERENCES `workout_targets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `workout_target_invites` ADD CONSTRAINT `fkey_fk_workout_target_invites_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `workout_target_invites` ADD CONSTRAINT `fkey_fk_workout_target_invites_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

