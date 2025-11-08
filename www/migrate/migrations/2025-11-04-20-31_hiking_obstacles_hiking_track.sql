
ALTER TABLE `hiking_obstacles` ADD `id_hiking_track` INT(11) NULL DEFAULT NULL AFTER `id_obstacle`;

ALTER TABLE `hiking_obstacles` ADD KEY `hiking_obstacles_id_hiking_track` (`id_hiking_track`);
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fk_hiking_obstacles_id_hiking_track` FOREIGN KEY (`id_hiking_track`) REFERENCES `hiking_tracks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
