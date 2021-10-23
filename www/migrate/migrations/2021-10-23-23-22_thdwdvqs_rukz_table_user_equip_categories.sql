
-- --------------------------------------------------------

--
-- Структура таблицы `user_equip_categories`
--

CREATE TABLE `user_equip_categories` (
  `id` int(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_equip_categories` ADD PRIMARY KEY (`id`);

ALTER TABLE `user_equip_categories` MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
