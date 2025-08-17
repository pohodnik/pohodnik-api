CREATE TABLE `hiking_repair_kit` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `id_hiking` INT(9) NOT NULL ,
  `name` VARCHAR(128) NOT NULL ,
  `comment` VARCHAR(512) NOT NULL ,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `creator_id` INT(9) NOT NULL ,
  `updated_at` DATETIME NULL ,
  `updater_id` INT(9) NULL,
   PRIMARY KEY (`id`) ) ENGINE = InnoDB COMMENT = 'Ремнабор для похода';

ALTER TABLE `hiking_repair_kit`
  ADD KEY `fk_hiking_repair_kit_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_repair_kit_creator_id` (`creator_id`),
  ADD KEY `fk_hiking_repair_kit_updater_id` (`updater_id`)
;

ALTER TABLE `hiking_repair_kit` ADD CONSTRAINT `fkey_hiking_repair_kit_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit` ADD CONSTRAINT `fkey_hiking_repair_kit_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit` ADD CONSTRAINT `fkey_hiking_repair_kit_updater_id` FOREIGN KEY (`updater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


CREATE TABLE `hiking_repair_kit_approvers` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_user` INT(9) NOT NULL ,
    `id_hiking` INT(9) NOT NULL ,
    `id_position` INT(3) NULL DEFAULT NULL,
    `date` DATETIME NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Подтверждение ремнабора';

ALTER TABLE `hiking_repair_kit_approvers`
  ADD KEY `fk_hiking_repair_kit_approvers_id_user` (`id_user`),
  ADD KEY `fk_hiking_repair_kit_approvers_id_hiking` (`id_hiking`)
  ADD KEY `fk_hiking_repair_kit_approvers_id_position` (`id_position`);

ALTER TABLE `hiking_repair_kit_approvers` ADD CONSTRAINT `fkey_hiking_repair_kit_approvers_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit_approvers` ADD CONSTRAINT `fkey_hiking_repair_kit_approvers_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit_approvers` ADD CONSTRAINT `fkey_hiking_repair_kit_approvers_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

CREATE TABLE `hiking_repair_kit_usages` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_hiking_repair_kit` INT(9) NOT NULL ,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `id_user` INT(9) NULL DEFAULT NULL,
    `comment` VARCHAR(512) NOT NULL ,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Использование ремнабора';

ALTER TABLE `hiking_repair_kit_usages`
  ADD KEY `fk_hiking_repair_kit_usages_id_user` (`id_user`),
  ADD KEY `fk_hiking_repair_kit_usages_created_at` (`created_at`),
  ADD KEY `fk_hiking_repair_kit_usages_id_hiking_repair_kit` (`id_hiking_repair_kit`);

ALTER TABLE `hiking_repair_kit_usages` ADD CONSTRAINT `fkey_hiking_repair_kit_usages_id_hiking_repair_kit` FOREIGN KEY (`id_hiking_repair_kit`) REFERENCES `hiking_repair_kit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit_usages` ADD CONSTRAINT `fkey_hiking_repair_kit_usages_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `hiking_repair_kit_usages` ADD CONSTRAINT `fkey_hiking_repair_kit_usages_created_at` FOREIGN KEY (`created_at`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
