ALTER TABLE `hiking_menu_saves`
    ADD `confirm_user` INT(9) NULL DEFAULT NULL AFTER `is_current`,
    ADD `confirm_date` DATETIME NULL DEFAULT NULL AFTER `confirm_user`;

ALTER TABLE `hiking_duty`
  ADD KEY `fk_hiking_hiking_menu_saves_confirm_user` (`confirm_user`)
;

ALTER TABLE `hiking_menu_saves` ADD CONSTRAINT `fk_hiking_hiking_menu_saves_confirm_user` FOREIGN KEY (`confirm_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


