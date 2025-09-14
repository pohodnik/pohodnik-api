
CREATE TABLE `hiking_finance_currencies` (
  `id` INT(2) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL ,
  `short_name` VARCHAR(8) NOT NULL ,
  `symbol` VARCHAR(1) NOT NULL ,
   PRIMARY KEY (`id`) ) ENGINE = InnoDB COMMENT = 'Валюты';

INSERT INTO hiking_finance_currencies VALUES 
(null, 'Российский рубль', 'RUB', '₽'),
(null, 'Казахский тенге', 'KZT', '〒');

ALTER TABLE `hiking_finance_receipt` ADD `summ_in_currency` FLOAT NULL DEFAULT NULL AFTER `summ`, 
ADD `id_currency` INT(2) NULL DEFAULT NULL AFTER `summ_in_currency`;

ALTER TABLE `hiking_finance_receipt` ADD KEY `hiking_finance_receipt_id_currency` (`id_currency`);
ALTER TABLE `hiking_finance_receipt` ADD CONSTRAINT `fkey_hiking_finance_receipt_id_currency` FOREIGN KEY (`id_currency`) REFERENCES `hiking_finance_currencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE `hiking_finance_payment` ADD `total_in_currency` FLOAT NULL DEFAULT NULL AFTER `total`, 
ADD `id_currency` INT(2) NULL DEFAULT NULL AFTER `total_in_currency`;

ALTER TABLE `hiking_finance_payment` ADD KEY `hiking_finance_payment_id_currency` (`id_currency`);
ALTER TABLE `hiking_finance_payment` ADD CONSTRAINT `fkey_hiking_finance_payment_id_currency` FOREIGN KEY (`id_currency`) REFERENCES `hiking_finance_currencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
