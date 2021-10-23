
-- --------------------------------------------------------

--
-- Структура таблицы `iv_ans`
--

CREATE TABLE `iv_ans` (
  `id` int(11) NOT NULL,
  `id_qq` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `iv_ans` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_qq` (`id_qq`,`id_user`), ADD KEY `fk_iv_ans_id_qq` (`id_qq`), ADD KEY `fk_iv_ans_id_user` (`id_user`);

ALTER TABLE `iv_ans` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_ans` ADD CONSTRAINT `fk_iv_ans_id_qq` FOREIGN KEY (`id_qq`) REFERENCES `iv_qq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_iv_ans_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
