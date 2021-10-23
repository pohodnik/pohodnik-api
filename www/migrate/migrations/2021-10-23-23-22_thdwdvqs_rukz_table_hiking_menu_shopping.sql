
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_menu_shopping`
--

CREATE TABLE `hiking_menu_shopping` (
  `id` int(11) NOT NULL,
  `id_hiking` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `amount` float(7,2) NOT NULL DEFAULT '0.00',
  `need_amount` float(6,2) DEFAULT NULL,
  `usages` varchar(512) NOT NULL,
  `price` float(7,2) NOT NULL DEFAULT '0.00',
  `is_complete` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список покупок';

ALTER TABLE `hiking_menu_shopping` ADD PRIMARY KEY (`id`), ADD KEY `hiking_menu_shopping_id_hiking` (`id_hiking`), ADD KEY `hiking_menu_shopping_id_product` (`id_product`), ADD KEY `hiking_menu_shopping_id_user` (`id_user`);

ALTER TABLE `hiking_menu_shopping` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_menu_shopping` ADD CONSTRAINT `hiking_menu_shopping_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_menu_shopping_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`) ON UPDATE CASCADE, ADD CONSTRAINT `hiking_menu_shopping_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
