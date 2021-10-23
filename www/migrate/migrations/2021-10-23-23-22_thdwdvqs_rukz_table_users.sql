
-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `hash` varchar(512) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `surname` varchar(32) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT '0' COMMENT '1-М; 2-Ж',
  `dob` date DEFAULT NULL COMMENT 'Дата рождения',
  `reg_date` datetime DEFAULT NULL,
  `ava` varchar(256) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(12) NOT NULL DEFAULT '',
  `skype` varchar(50) NOT NULL DEFAULT '',
  `icq` varchar(12) NOT NULL DEFAULT '',
  `skills` int(5) NOT NULL DEFAULT '0' COMMENT 'походный опыт',
  `photo_50` varchar(255) NOT NULL DEFAULT '',
  `photo_100` varchar(255) NOT NULL DEFAULT '',
  `photo_200_orig` varchar(255) NOT NULL DEFAULT '',
  `photo_max` varchar(255) NOT NULL DEFAULT '',
  `photo_max_orig` varchar(255) NOT NULL DEFAULT '',
  `vk_id` varchar(255) NOT NULL DEFAULT '',
  `weight` int(3) NOT NULL DEFAULT '70',
  `growth` int(3) NOT NULL DEFAULT '180' COMMENT 'рост',
  `id_region` int(9) DEFAULT '1067455',
  `uniq_code` varchar(96) CHARACTER SET cp1251 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD KEY `fk_users_id_region1` (`id_region`);

ALTER TABLE `users` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users` ADD CONSTRAINT `fk_users_id_region` FOREIGN KEY (`id_region`) REFERENCES `geo_regions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
