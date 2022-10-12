ALTER TABLE `hiking_finance_payment` ADD `id_target_user` INT(9) DEFAULT NULL COMMENT 'Кому был зачислен платёж' AFTER `id_user`;
ALTER TABLE `hiking_finance_payment` ADD CONSTRAINT `fk_hiking_finance_payment_id_target_user` FOREIGN KEY (`id_target_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
