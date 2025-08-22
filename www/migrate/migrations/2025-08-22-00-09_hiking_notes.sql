
CREATE TABLE `hiking_notes` (
  `id` INT(9) NOT NULL AUTO_INCREMENT,
  `id_hiking` INT(9) NOT NULL ,
  `coordinates` VARCHAR(128) NOT NULL ,
  `comment` VARCHAR(512) NOT NULL ,
  `created_at` DATETIME NOT NULL,
  `uploaded_at` DATETIME NOT NULL  DEFAULT CURRENT_TIMESTAMP ,
  `creator_id` INT(9) NOT NULL ,
  `updated_at` DATETIME NULL ,
  `updater_id` INT(9) NULL,
   PRIMARY KEY (`id`) ) ENGINE = InnoDB COMMENT = 'Заметки по походу';

ALTER TABLE `hiking_notes`
  ADD KEY `fk_hiking_notes_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_notes_creator_id` (`creator_id`),
  ADD KEY `fk_hiking_notes_updater_id` (`updater_id`)
;

ALTER TABLE `hiking_notes` ADD CONSTRAINT `fkey_hiking_notes_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_notes` ADD CONSTRAINT `fkey_hiking_notes_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `hiking_notes` ADD CONSTRAINT `fkey_hiking_notes_updater_id` FOREIGN KEY (`updater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
