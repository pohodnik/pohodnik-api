
-- --------------------------------------------------------

--
-- Структура таблицы `iv_qq`
--

CREATE TABLE `iv_qq` (
  `id` int(9) NOT NULL,
  `id_iv` int(5) NOT NULL,
  `name` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `id_type` int(2) NOT NULL,
  `is_custom` tinyint(1) NOT NULL COMMENT 'Добавлять "Свой вариант: ..."',
  `is_require` tinyint(1) NOT NULL COMMENT 'Обязательно для заполнения',
  `is_multi` tinyint(1) NOT NULL COMMENT 'разрешить выбор нескольких варинатов',
  `is_private` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Вопросы';

ALTER TABLE `iv_qq` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_qq_id_iv` (`id_iv`), ADD KEY `fk_iv_qq_id_type` (`id_type`);

ALTER TABLE `iv_qq` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_qq` ADD CONSTRAINT `fk_iv_qq_id_iv` FOREIGN KEY (`id_iv`) REFERENCES `iv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_iv_qq_id_type` FOREIGN KEY (`id_type`) REFERENCES `iv_qq_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
