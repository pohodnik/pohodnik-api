
-- --------------------------------------------------------

--
-- Структура таблицы `user_subscribes_types`
--

CREATE TABLE `user_subscribes_types` (
  `id` int(9) NOT NULL,
  `id_subs` int(9) NOT NULL,
  `id_type` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_subscribes_types` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_subscribes_types_id_subs` (`id_subs`), ADD KEY `fk_user_subscribes_types_id_type` (`id_type`);

ALTER TABLE `user_subscribes_types` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_subscribes_types` ADD CONSTRAINT `fk_user_subscribes_types_id_subs` FOREIGN KEY (`id_subs`) REFERENCES `user_subscribes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_subscribes_types_id_type` FOREIGN KEY (`id_type`) REFERENCES `hiking_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
