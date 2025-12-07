ALTER TABLE `user_allergies`
ADD `id_medicament` INT(9) NULL DEFAULT NULL AFTER `id_product`,
ADD `created_at` DATETIME NULL DEFAULT NULL AFTER `type`,
ADD `updated_at` DATETIME NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `user_allergies` ADD KEY `user_allergies_id_medicament` (`id_medicament`);
ALTER TABLE `user_allergies` ADD CONSTRAINT `fk_user_allergies_id_medicament` FOREIGN KEY (`id_medicament`) REFERENCES `medicaments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
