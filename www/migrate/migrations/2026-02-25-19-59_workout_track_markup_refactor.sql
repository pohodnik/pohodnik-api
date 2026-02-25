ALTER TABLE `hiking_obstacles` CHANGE `id_hiking_break` `id_track_markup` INT(11) NULL DEFAULT NULL;

ALTER TABLE `hiking_obstacles` DROP FOREIGN KEY `fk_hiking_obstacles_id_hiking_break`;
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fk_hiking_obstacles_id_track_markup` 
FOREIGN KEY (`id_track_markup`) REFERENCES `workout_track_markup`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;