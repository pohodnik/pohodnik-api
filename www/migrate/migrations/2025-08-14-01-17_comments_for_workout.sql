ALTER TABLE `comments_branch` ADD `id_workout` INT(11) NULL DEFAULT NULL AFTER `id_route`;
ALTER TABLE `comments_branch` ADD `id_workout_group` INT(11) NULL DEFAULT NULL AFTER `id_workout`;

ALTER TABLE `comments_branch`
  ADD CONSTRAINT `fk_comments_branch_id_workout` FOREIGN KEY (`id_workout`) REFERENCES `workouts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comments_branch`
  ADD CONSTRAINT `fk_comments_branch_id_workout_group` FOREIGN KEY (`id_workout_group`) REFERENCES `workouts_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
