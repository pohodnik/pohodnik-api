
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_finance`
--

CREATE TABLE `hiking_finance` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_product` int(9) DEFAULT NULL,
  `id_unit` int(3) DEFAULT NULL,
  `weight` int(4) NOT NULL DEFAULT '0',
  `amount` float(5,3) NOT NULL DEFAULT '1.000',
  `cost` float(5,2) NOT NULL DEFAULT '0.00',
  `id_receipt` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `is_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `id_author` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_finance` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_finance_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_finance_id_user` (`id_user`), ADD KEY `fk_hiking_finance_id_author` (`id_author`), ADD KEY `fk_hiking_finance_id_receipt` (`id_receipt`), ADD KEY `fk_hiking_finance_id_unit` (`id_unit`);

ALTER TABLE `hiking_finance` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_finance` ADD CONSTRAINT `fk_hiking_finance_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_finance_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_finance_id_receipt` FOREIGN KEY (`id_receipt`) REFERENCES `hiking_finance_receipt` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_finance_id_unit` FOREIGN KEY (`id_unit`) REFERENCES `recipes_products_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_finance_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
