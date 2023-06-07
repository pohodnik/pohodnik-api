CREATE TABLE `thdwdvqs_rukz`.`hiking_duty` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_hiking` INT(9) NOT NULL ,
    `id_user` INT(9) NOT NULL ,
    `date` DATE NOT NULL ,
    `comment` VARCHAR(255) NOT NULL ,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
    `updated_at` DATETIME NULL DEFAULT NULL ,
    `updated_id` INT(9) NULL DEFAULT NULL , PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Дежурства в походе';

ALTER TABLE `hiking_duty`
  ADD KEY `fk_hiking_duty_id_user` (`id_user`),
  ADD KEY `fk_hiking_duty_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_duty_creator_id` (`creator_id`),
  ADD KEY `fk_hiking_duty_updator_id` (`updated_id`)
;

ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_duty_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_duty_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_duty_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_duty_updated_id` FOREIGN KEY (`updated_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


