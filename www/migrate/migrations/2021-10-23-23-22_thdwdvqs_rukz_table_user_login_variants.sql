
-- --------------------------------------------------------

--
-- Структура таблицы `user_login_variants`
--

CREATE TABLE `user_login_variants` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `login` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `social_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `network` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'login',
  `provider` enum('vk','odnoklassniki','mailru','yandex','google','facebook','strava') COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_page` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Варианты залогинивания';

ALTER TABLE `user_login_variants` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_login_variants_id_user` (`id_user`);

ALTER TABLE `user_login_variants` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_login_variants` ADD CONSTRAINT `fk_user_login_variants_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
