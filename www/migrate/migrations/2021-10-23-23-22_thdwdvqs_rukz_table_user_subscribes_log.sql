
-- --------------------------------------------------------

--
-- Структура таблицы `user_subscribes_log`
--

CREATE TABLE `user_subscribes_log` (
  `id` int(9) NOT NULL,
  `id_subscribe` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `date` date NOT NULL,
  `sender` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_subscribes_log` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_subscribes_log_subs` (`id_subscribe`), ADD KEY `fk_user_subscribes_log_hiking` (`id_hiking`);

ALTER TABLE `user_subscribes_log` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_subscribes_log` ADD CONSTRAINT `fk_user_subscribes_log_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_subscribes_log_subs` FOREIGN KEY (`id_subscribe`) REFERENCES `user_subscribes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
