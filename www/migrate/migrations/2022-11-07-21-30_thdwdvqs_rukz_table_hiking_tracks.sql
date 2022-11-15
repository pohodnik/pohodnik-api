ALTER TABLE `hiking_tracks` ADD `id_workout_track` INT(9) NULL DEFAULT NULL AFTER `id_hiking`;

ALTER TABLE `hiking_tracks` ADD CONSTRAINT `fk_hiking_tracks_id_workout_track` FOREIGN KEY (`id_workout_track`) REFERENCES `workout_tracks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

RENAME TABLE `workouts` TO `workout_tracks`;
ALTER TABLE `hiking_tracks` CHANGE `url` `url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
UPDATE hiking_tracks SET id_workout_track = (SELECT workout_tracks.id FROM workout_tracks WHERE workout_tracks.description = hiking_tracks.url);