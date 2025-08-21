ALTER TABLE `hiking_first_aid_kit` ADD `id_assignee` INT(11) NULL DEFAULT NULL AFTER `deadline`;

ALTER TABLE `hiking_first_aid_kit`
  ADD CONSTRAINT `fk_hiking_first_aid_kit_id_assignee` FOREIGN KEY (`id_assignee`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `hiking_repair_kit` ADD `weight` INT(5) NOT NULL DEFAULT 23 AFTER `name`;
ALTER TABLE `hiking_repair_kit` ADD `id_assignee` INT(11) NULL DEFAULT NULL AFTER `comment`;

ALTER TABLE `hiking_repair_kit`
  ADD CONSTRAINT `fk_hiking_repair_kit_id_assignee` FOREIGN KEY (`id_assignee`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
