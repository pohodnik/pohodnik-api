
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_finance_receipt_participation`
--

CREATE TABLE `hiking_finance_receipt_participation` (
  `id` int(9) NOT NULL,
  `id_hiking_receipt` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `id_author` int(8) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Если не все скидываются на чек';

ALTER TABLE `hiking_finance_receipt_participation` ADD PRIMARY KEY (`id`), ADD KEY `hiking_finance_receipt_participation_id_hr` (`id_hiking_receipt`), ADD KEY `hiking_finance_receipt_participation_id_user` (`id_user`), ADD KEY `hiking_finance_receipt_participation_id_author` (`id_author`);

ALTER TABLE `hiking_finance_receipt_participation` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_finance_receipt_participation` ADD CONSTRAINT `hiking_finance_receipt_participation_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `hiking_finance_receipt_participation_id_hr` FOREIGN KEY (`id_hiking_receipt`) REFERENCES `hiking_finance_receipt` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_finance_receipt_participation_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
