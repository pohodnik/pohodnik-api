ALTER TABLE `hiking_first_aid_kit_approvers` ADD `id_position` INT(3) NULL DEFAULT NULL AFTER `id_user`;

ALTER TABLE `hiking_first_aid_kit_approvers`
    ADD KEY `fk_hiking_first_aid_kit_approvers_id_position` (`id_position`);

ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_first_aid_kit_approvers_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
