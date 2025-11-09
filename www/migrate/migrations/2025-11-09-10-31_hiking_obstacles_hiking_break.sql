
ALTER TABLE `hiking_obstacles` ADD `id_hiking_break` INT(11) NULL DEFAULT NULL AFTER `id_hiking_track`;

ALTER TABLE `hiking_obstacles` ADD KEY `hiking_obstacles_id_hiking_break` (`id_hiking_break`);
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fk_hiking_obstacles_id_hiking_break` FOREIGN KEY (`id_hiking_break`) REFERENCES `hiking_tracks_break` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
