ALTER TABLE `obstacles` CHANGE `type` `type` ENUM('pass','peak','poi') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `route_objects` ADD `id_obstacle` INT(9) NULL DEFAULT NULL AFTER `id_mountain_pass`;

ALTER TABLE `route_objects`
  ADD CONSTRAINT `fk_ro_id_obstacle` FOREIGN KEY (`id_obstacle`) REFERENCES `obstacles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
