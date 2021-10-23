
-- --------------------------------------------------------

--
-- Структура таблицы `iv_qq_type`
--

CREATE TABLE `iv_qq_type` (
  `id` int(2) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `is_multi_available` tinyint(1) NOT NULL DEFAULT '0',
  `hint` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Типы вопросов';

ALTER TABLE `iv_qq_type` ADD PRIMARY KEY (`id`);

ALTER TABLE `iv_qq_type` MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
