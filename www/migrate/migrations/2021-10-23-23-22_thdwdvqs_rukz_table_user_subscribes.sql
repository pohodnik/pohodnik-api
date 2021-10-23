
-- --------------------------------------------------------

--
-- Структура таблицы `user_subscribes`
--

CREATE TABLE `user_subscribes` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `email` varchar(96) NOT NULL,
  `confirm_code` varchar(255) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Подписки';

ALTER TABLE `user_subscribes` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_subscribes_id_user` (`id_user`);

ALTER TABLE `user_subscribes` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_subscribes` ADD CONSTRAINT `fk_user_subscribes_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
