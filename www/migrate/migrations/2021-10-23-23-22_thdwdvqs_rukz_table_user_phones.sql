
-- --------------------------------------------------------

--
-- Структура таблицы `user_phones`
--

CREATE TABLE `user_phones` (
  `id` int(9) NOT NULL,
  `id_user` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `is_contact` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'показывать ли как контактактный',
  `is_send_sms` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отправлять ли смс',
  `sms_api_key` blob COMMENT 'шифрованый ключ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_phones` ADD PRIMARY KEY (`id`), ADD KEY `user_phones_id_user` (`id_user`);

ALTER TABLE `user_phones` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_phones` ADD CONSTRAINT `user_phones_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
