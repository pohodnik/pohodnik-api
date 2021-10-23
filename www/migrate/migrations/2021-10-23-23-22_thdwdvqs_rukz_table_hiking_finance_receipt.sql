
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_finance_receipt`
--

CREATE TABLE `hiking_finance_receipt` (
  `id` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_author` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `img_600` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_100` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_orig` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summ` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `hiking_finance_receipt` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_finance_receipt_id_hiking` (`id_hiking`), ADD KEY `fk_hiking_finance_receipt_id_user` (`id_user`), ADD KEY `fk_hiking_finance_receipt_id_aUTHOR` (`id_author`);

ALTER TABLE `hiking_finance_receipt` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_finance_receipt` ADD CONSTRAINT `fk_hiking_finance_receipt_id_aUTHOR` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `fk_hiking_finance_receipt_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_finance_receipt_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
