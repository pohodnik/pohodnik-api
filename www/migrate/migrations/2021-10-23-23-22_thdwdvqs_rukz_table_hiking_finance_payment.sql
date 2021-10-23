
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_finance_payment`
--

CREATE TABLE `hiking_finance_payment` (
  `id` int(8) NOT NULL,
  `id_hiking` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `total` float NOT NULL,
  `date` date NOT NULL,
  `id_author` int(8) NOT NULL,
  `date_create` datetime NOT NULL,
  `comment` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Взносы денег за поход';

ALTER TABLE `hiking_finance_payment` ADD PRIMARY KEY (`id`), ADD KEY `hiking_finance_payment_fk_hiking` (`id_hiking`), ADD KEY `hiking_finance_payment_fk_user` (`id_user`), ADD KEY `hiking_finance_payment_fk_author` (`id_author`);

ALTER TABLE `hiking_finance_payment` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_finance_payment` ADD CONSTRAINT `hiking_finance_payment_fk_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `hiking_finance_payment_fk_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_finance_payment_fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
