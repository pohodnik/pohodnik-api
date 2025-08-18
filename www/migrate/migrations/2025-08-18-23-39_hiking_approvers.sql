CREATE TABLE `hiking_approvers`(
  `id` INT(9) NOT NULL AUTO_INCREMENT ,
  `id_hiking` INT(9) NOT NULL ,
  `id_user` INT(9) NOT NULL ,
  `id_position` INT(3) NULL DEFAULT NULL,
  `entity_id` INT(9) NULL DEFAULT NULL ,
  `entity_type` ENUM('obstacle', 'schedule', 'menu','first_aid_kit','repair_kit') NOT NULL DEFAULT 'schedule',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Подписи для похода';

ALTER TABLE `hiking_approvers`
  ADD KEY `fk_hiking_approvers_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_approvers_id_user` (`id_user`),
  ADD KEY `fk_hiking_approvers_id_position` (`id_position`)
;

ALTER TABLE `hiking_approvers` ADD CONSTRAINT `fkey_hiking_approvers_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_approvers` ADD CONSTRAINT `fkey_hiking_approvers_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_approvers` ADD CONSTRAINT `hiking_approvers_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

