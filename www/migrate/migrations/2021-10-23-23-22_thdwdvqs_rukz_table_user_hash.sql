
-- --------------------------------------------------------

--
-- Структура таблицы `user_hash`
--

CREATE TABLE `user_hash` (
  `id` int(11) NOT NULL,
  `id_user` int(8) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `date_start` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Токены';

ALTER TABLE `user_hash` ADD PRIMARY KEY (`id`), ADD KEY `user_hash_id_user_fk_1` (`id_user`);

ALTER TABLE `user_hash` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_hash` ADD CONSTRAINT `user_hash_id_user_fk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
