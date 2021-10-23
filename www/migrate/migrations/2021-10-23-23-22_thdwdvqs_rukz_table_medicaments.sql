
-- --------------------------------------------------------

--
-- Структура таблицы `medicaments`
--

CREATE TABLE `medicaments` (
  `id` int(8) NOT NULL COMMENT 'id лекарства',
  `name` varchar(255) NOT NULL COMMENT 'название лекарства',
  `medical_group` int(4) NOT NULL COMMENT 'категория лекарства',
  `form` int(4) NOT NULL COMMENT 'форма выпуска (ампула, таблетка))',
  `dosage` varchar(255) NOT NULL COMMENT 'дозировка и способ применения',
  `for_use` varchar(255) NOT NULL COMMENT 'показания к применению',
  `contraindications` varchar(255) NOT NULL DEFAULT 'Нет' COMMENT 'противопоказания'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список медикаментов с показаниями и противопоказаниями';

ALTER TABLE `medicaments` ADD PRIMARY KEY (`id`), ADD KEY `medicaments_categories_fk` (`medical_group`), ADD KEY `medicaments_form_fk` (`form`);

ALTER TABLE `medicaments` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT id лекарства;

ALTER TABLE `medicaments` ADD CONSTRAINT `medicaments_categories_fk` FOREIGN KEY (`medical_group`) REFERENCES `medicaments_categories` (`id`), ADD CONSTRAINT `medicaments_form_fk` FOREIGN KEY (`form`) REFERENCES `medicaments_form` (`id`);
