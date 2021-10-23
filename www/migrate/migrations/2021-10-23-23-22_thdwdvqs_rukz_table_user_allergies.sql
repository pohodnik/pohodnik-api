
-- --------------------------------------------------------

--
-- Структура таблицы `user_allergies`
--

CREATE TABLE `user_allergies` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` varchar(512) NOT NULL,
  `id_product` int(9) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1-Лекарство, 2- продукт, 3- проч'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_allergies` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_allergies_id_user` (`id_user`), ADD KEY `fk_user_allergies_id_product` (`id_product`);

ALTER TABLE `user_allergies` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_allergies` ADD CONSTRAINT `fk_user_allergies_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_allergies_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
