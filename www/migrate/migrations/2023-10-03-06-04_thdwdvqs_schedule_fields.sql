ALTER TABLE `hiking_schedule`
    ADD `description` VARCHAR(512) NULL DEFAULT NULL COMMENT 'Описание' AFTER `kkal`,
    ADD `link` INT NULL DEFAULT NULL COMMENT 'Ссылка' AFTER `description`,
    ADD `cost` SMALLINT NULL DEFAULT NULL COMMENT 'Стоимость' AFTER `link`;
