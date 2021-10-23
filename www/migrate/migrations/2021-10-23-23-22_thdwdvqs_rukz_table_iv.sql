
-- --------------------------------------------------------

--
-- Структура таблицы `iv`
--

CREATE TABLE `iv` (
  `id` int(7) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `id_author` int(9) DEFAULT NULL,
  `date_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_finish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hello_text` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Текст приветствия',
  `by_text` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Текст завершения',
  `members_limit` int(3) NOT NULL DEFAULT '0' COMMENT 'Ограничение кол-ва зарегестрированных',
  `id_hiking` int(9) DEFAULT NULL,
  `main` int(1) NOT NULL DEFAULT '0' COMMENT 'Основной опрос для похода'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Опросы';

ALTER TABLE `iv` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_id_author` (`id_author`), ADD KEY `fk_iv_id_hiking` (`id_hiking`);

ALTER TABLE `iv` MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv` ADD CONSTRAINT `fk_iv_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_iv_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
