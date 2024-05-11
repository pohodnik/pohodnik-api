ALTER TABLE `route_objects` ADD `trackData` TEXT NULL DEFAULT NULL COMMENT 'Разделенные переносом строки последовательности xneek-gpx' AFTER `coordinates`;
ALTER TABLE `route_objects` CHANGE `coordinates` `coordinates` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
