
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_menu_products_force`
--

CREATE TABLE `hiking_menu_products_force` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `date` datetime NOT NULL,
  `id_author` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Принудительное распределение продуктов на участников';

ALTER TABLE `hiking_menu_products_force` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_menu_products_force_id_author` (`id_author`), ADD KEY `fk_hiking_menu_products_force_id_product` (`id_product`), ADD KEY `fk_hiking_menu_products_force_id_user` (`id_user`), ADD KEY `fk_hiking_menu_products_force_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_menu_products_force` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_menu_products_force` ADD CONSTRAINT `fk_hiking_menu_products_force_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `fk_hiking_menu_products_force_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_hiking_menu_products_force_id_product` FOREIGN KEY (`id_product`) REFERENCES `recipes_products` (`id`), ADD CONSTRAINT `fk_hiking_menu_products_force_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
