CREATE TABLE `thdwdvqs_rukz`.`hiking_first_aid_kit_approvers` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_user` INT(9) NOT NULL ,
    `id_hiking` INT(9) NOT NULL ,
    `date` DATETIME NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Подтверждение аптечки';

ALTER TABLE `hiking_first_aid_kit_approvers`
    ADD KEY `fk_hiking_first_aid_kit_approvers_id_user` (`id_user`),
  ADD KEY `fk_hiking_first_aid_kit_approvers_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_first_aid_kit_approvers_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_duty` ADD CONSTRAINT `fkey_hiking_first_aid_kit_approvers_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

