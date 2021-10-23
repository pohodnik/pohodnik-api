
-- --------------------------------------------------------

--
-- Структура таблицы `user_wikimapia_keys`
--

CREATE TABLE `user_wikimapia_keys` (
  `id` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_wikimapia_keys` ADD PRIMARY KEY (`id`), ADD KEY `user_wikimapia_keys_fk_user` (`id_user`);

ALTER TABLE `user_wikimapia_keys` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_wikimapia_keys` ADD CONSTRAINT `user_wikimapia_keys_fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
