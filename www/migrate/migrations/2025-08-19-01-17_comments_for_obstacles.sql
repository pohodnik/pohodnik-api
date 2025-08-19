ALTER TABLE `comments_branch` ADD `id_obstacle` INT(11) NULL DEFAULT NULL AFTER `id_workout_group`;
ALTER TABLE `comments_branch` ADD `id_hiking_obstacle` INT(11) NULL DEFAULT NULL AFTER `id_obstacle`;

ALTER TABLE `comments_branch`
  ADD CONSTRAINT `fk_comments_branch_id_obstacle` FOREIGN KEY (`id_obstacle`) REFERENCES `obstacles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comments_branch`
  ADD CONSTRAINT `fk_comments_branch_id_hiking_obstacle` FOREIGN KEY (`id_hiking_obstacle`) REFERENCES `hiking_obstacles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
