CREATE TABLE `hiking_timezones` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `id_hiking` INT(9) NOT NULL ,
    `date_in` DATETIME NOT NULL ,
    `date_out` DATETIME NOT NULL ,
    `timezone` VARCHAR(96) NOT NULL,
    `comment` VARCHAR(255) NOT NULL DEFAULT '',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
    `updated_at` DATETIME NULL DEFAULT NULL ,
    `updated_id` INT(9) NULL DEFAULT NULL , PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Смена часовых поясов в походе';

ALTER TABLE `hiking_timezones`
  ADD KEY `fk_hiking_timezones_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_timezones_creator_id` (`creator_id`),
  ADD KEY `fk_hiking_timezones_updator_id` (`updated_id`)
;

ALTER TABLE `hiking_timezones` ADD CONSTRAINT `fkey_hiking_tz_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_timezones` ADD CONSTRAINT `fkey_hiking_tz_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `hiking_timezones` ADD CONSTRAINT `fkey_hiking_tz_updated_id` FOREIGN KEY (`updated_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


