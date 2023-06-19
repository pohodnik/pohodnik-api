CREATE TABLE `thdwdvqs_rukz`.`comments_branch` (
`id` INT(9) NOT NULL AUTO_INCREMENT ,
`id_hiking` INT(9) NULL DEFAULT NULL ,
`id_position` INT(9) NULL DEFAULT NULL ,
`id_recipe` INT(9) NULL DEFAULT NULL ,
`id_route` INT(9) NULL DEFAULT NULL ,
`created_at` DATETIME NOT NULL ,
`id_author` INT(9) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Ветки комментариев';

ALTER TABLE `comments_branch`
  ADD KEY `fk_comments_branch_id_author` (`id_author`),
  ADD KEY `fk_comments_branch_id_hiking` (`id_hiking`),
  ADD KEY `fk_comments_branch_id_route` (`id_route`),
  ADD KEY `fk_comments_branch_id_route` (`id_route`),
  ADD KEY `fk_comments_branch_id_position` (`id_position`);

ALTER TABLE `comments_branch`
    ADD CONSTRAINT `fkey_comments_branch_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_branch_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_branch_id_recipe` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_branch_id_route` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_branch_id_position` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
