CREATE TABLE `external_apps` (
  `id` int(4) NOT NULL,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `img_url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `callback` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `last_call` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Внешние приложения';

ALTER TABLE `external_apps` ADD PRIMARY KEY (`id`);

ALTER TABLE `external_apps` MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_hash` ADD `id_external_app` INT(4) NULL DEFAULT NULL AFTER `date_start`;
ALTER TABLE `user_hash` ADD CONSTRAINT `fk_user_hash_external_app` FOREIGN KEY (`id_external_app`) REFERENCES `external_apps` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

