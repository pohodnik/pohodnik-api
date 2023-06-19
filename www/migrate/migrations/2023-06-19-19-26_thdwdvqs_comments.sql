CREATE TABLE `thdwdvqs_rukz`.`comments` (
`id` INT(9) NOT NULL AUTO_INCREMENT ,
`id_comments_branch` INT(9) NOT NULL,
`id_reply_comment` INT(9) NULL DEFAULT NULL ,
`id_author` INT(9) NOT NULL ,
`comment` text COLLATE utf16_unicode_ci NOT NULL,
`is_pinned` BOOLEAN NOT NULL DEFAULT FALSE ,
`created_at` DATETIME NOT NULL ,
`updated_at` DATETIME NULL DEFAULT NULL,
`deleted_at` DATETIME NULL DEFAULT NULL,
PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Комментарии';

ALTER TABLE `comments`
  ADD KEY `fk_comments_id_author` (`id_author`),
  ADD KEY `fk_comments_id_comments_branch` (`id_comments_branch`),
  ADD KEY `fk_comments_id_reply_comment` (`id_reply_comment`);

ALTER TABLE `comments`
    ADD CONSTRAINT `fkey_comments_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_id_comments_branch` FOREIGN KEY (`id_comments_branch`) REFERENCES `comments_branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fkey_comments_id_reply_comment` FOREIGN KEY (`id_reply_comment`) REFERENCES `comments_branch` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
