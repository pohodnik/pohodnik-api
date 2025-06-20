CREATE TABLE `hiking_finance_receipt_categories` (
  `id` int(3) NOT NULL,
  `name` varchar(64) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_finance_receipt_categories` ADD PRIMARY KEY (`id`);
ALTER TABLE `hiking_finance_receipt_categories` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_finance_receipt` ADD `id_category` int(3) NULL DEFAULT NULL COMMENT 'Категория расхода' AFTER `id_hiking`;
ALTER TABLE `hiking_finance_receipt` ADD CONSTRAINT `fk_hiking_finance_receipt_id_category` FOREIGN KEY (`id_category`) REFERENCES `hiking_finance_receipt_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

INSERT INTO `hiking_finance_receipt_categories` (`id`, `name`, `color`, `comment`)
VALUES
(NULL, 'Провизия', '#ff9800', 'Продукты покупаемые в поход для готовки'),
(NULL, 'Транспорт', '#ffeb3b', 'Трансфер, билеты итд'),
(NULL, 'Аренда', '#d500f9', 'Например аренда снаряжения'),
(NULL, 'Проживание', '#651fff', 'Гостиницы, хостелы, приюты итд'),
(NULL, 'Питание', '#4caf50', 'Готовое питание купленное в походе (мороженое, пирожные итп)'),
(NULL, 'Развлечения', '#f73378', 'Плата за развлечения'),
(NULL, 'Услуги', '#00e5ff', 'Плата за услуги'),
(NULL, 'Топливо', '#ff4569', 'Газ, бензин итд');
