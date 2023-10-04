CREATE TABLE `thdwdvqs_rukz`.`obstacles` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
	`description` VARCHAR(512) NOT NULL ,
	`coordinates` point NOT NULL,
	`altitude` int(4) NOT NULL,
    `link` VARCHAR(255) NOT NULL ,
    `comment` VARCHAR(255) NOT NULL ,
	`type` ENUM('pass','peak') NOT NULL ,
	`category` ENUM('no', '1a','1b','2a','2b','3a','3b','4a','4b','5a','5b','6a','6b') NOT NULL,
	`id_geo_region` int(9) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
    `updated_at` DATETIME NULL DEFAULT NULL ,
    `updated_id` INT(9) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Локальные препятствия в походах';

ALTER TABLE `obstacles`
  ADD KEY `fk_obstacles_id_geo_region` (`id_geo_region`),
  ADD KEY `fk_obstacles_creator_id` (`creator_id`),
  ADD KEY `fk_obstacles_updator_id` (`updated_id`)
;

ALTER TABLE `obstacles` ADD CONSTRAINT `fkey_obstacles_id_geo_region` FOREIGN KEY (`id_geo_region`) REFERENCES `geo_regions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `obstacles` ADD CONSTRAINT `fkey_obstacles_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `obstacles` ADD CONSTRAINT `fkey_obstacles_updated_id` FOREIGN KEY (`updated_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


CREATE TABLE `thdwdvqs_rukz`.`hiking_obstacles` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
	`id_hiking` int(9) NOT NULL,
	`id_obstacle` int(9) NOT NULL,
	`description` text,
	`description_in` text,
	`description_out` text,
	
	`date_in` DATETIME NOT NULL ,
	`date_out` DATETIME NOT NULL ,

    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
    `updated_at` DATETIME NULL DEFAULT NULL ,
    `updated_id` INT(9) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Преодаленные локальные препятствия в походе';


ALTER TABLE `hiking_obstacles`
  ADD KEY `fk_hiking_obstacles_id_hiking` (`id_hiking`),
  ADD KEY `fk_hiking_obstacles_id_obstacle` (`id_obstacle`),
  ADD KEY `fk_hiking_obstacles_creator_id` (`creator_id`),
  ADD KEY `fk_hiking_obstacles_updator_id` (`updated_id`)
;

ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fkey_hiking_obstacles_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fkey_hiking_obstacles_id_obstacle` FOREIGN KEY (`id_obstacle`) REFERENCES `obstacles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fkey_hiking_obstacles_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `hiking_obstacles` ADD CONSTRAINT `fkey_hiking_obstacles_updated_id` FOREIGN KEY (`updated_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

CREATE TABLE `thdwdvqs_rukz`.`hiking_obstacles_members` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
	`id_hiking_obstacle` int(9) NOT NULL,
	`id_user` int(9) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Преодаленные локальные препятствия в походе';


ALTER TABLE `hiking_obstacles_members`
  ADD KEY `fk_hiking_obstacles_members_id_hiking_obstacle` (`id_hiking_obstacle`),
  ADD KEY `fk_obstacles_id_user` (`id_user`)
;

ALTER TABLE `hiking_obstacles_members` ADD CONSTRAINT `fkey_hiking_obstacles_members_id_hiking_obstacle` FOREIGN KEY (`id_hiking_obstacle`) REFERENCES `hiking_obstacles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_obstacles_members` ADD CONSTRAINT `fkey_hiking_obstacles_members_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `thdwdvqs_rukz`.`hiking_obstacles_photos` (
    `id` INT(9) NOT NULL AUTO_INCREMENT ,
	`id_hiking_obstacle` int(9) NOT NULL,
	`url_preview` VARCHAR(255) NOT NULL ,
	`url` VARCHAR(255) NOT NULL ,
	`date` DATETIME NOT NULL ,
	`comment` VARCHAR(512) NOT NULL ,

    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `creator_id` INT(9) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Фотографии локальных препятствий в походе';


ALTER TABLE `hiking_obstacles_photos`
  ADD KEY `fk_hiking_obstacles_photos_id_hiking_obstacle` (`id_hiking_obstacle`),
  ADD KEY `fk_hiking_obstacles_photos_creator_id` (`creator_id`)
;

ALTER TABLE `hiking_obstacles_photos` ADD CONSTRAINT `fkey_hiking_obstacles_photos_id_hiking_obstacle` FOREIGN KEY (`id_hiking_obstacle`) REFERENCES `hiking_obstacles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `hiking_obstacles_photos` ADD CONSTRAINT `fkey_hiking_obstacles_photos_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
