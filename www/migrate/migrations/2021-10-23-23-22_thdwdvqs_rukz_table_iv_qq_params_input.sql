
-- --------------------------------------------------------

--
-- Структура таблицы `iv_qq_params_input`
--

CREATE TABLE `iv_qq_params_input` (
  `id` int(9) NOT NULL,
  `id_qq` int(9) NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text' COMMENT 'Тип поля ввода (HTML)',
  `pattern` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '.*' COMMENT 'шаблон для ввода Регулярное выражение',
  `placeholder` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `min` int(12) NOT NULL DEFAULT '1',
  `max` int(12) NOT NULL DEFAULT '99',
  `step` float(3,2) NOT NULL DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Настройки для вопроса типа "Ввод"';

ALTER TABLE `iv_qq_params_input` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_qq_params_input_id_qq` (`id_qq`);

ALTER TABLE `iv_qq_params_input` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_qq_params_input` ADD CONSTRAINT `fk_iv_qq_params_input_id_qq` FOREIGN KEY (`id_qq`) REFERENCES `iv_qq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
