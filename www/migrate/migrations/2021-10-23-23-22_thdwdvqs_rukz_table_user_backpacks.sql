
-- --------------------------------------------------------

--
-- Структура таблицы `user_backpacks`
--

CREATE TABLE `user_backpacks` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float(5,2) NOT NULL,
  `value` float(5,2) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `user_backpacks` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_backpacks_id_user` (`id_user`);

ALTER TABLE `user_backpacks` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_backpacks` ADD CONSTRAINT `fk_user_backpacks_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
