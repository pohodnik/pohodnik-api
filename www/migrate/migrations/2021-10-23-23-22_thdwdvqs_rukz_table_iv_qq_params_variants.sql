
-- --------------------------------------------------------

--
-- Структура таблицы `iv_qq_params_variants`
--

CREATE TABLE `iv_qq_params_variants` (
  `id` int(9) NOT NULL,
  `id_qq` int(9) NOT NULL,
  `value` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `order_index` int(3) NOT NULL DEFAULT '0' COMMENT 'для сортировки внутри вопроса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Список вариантов ответов на вопрос';

ALTER TABLE `iv_qq_params_variants` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_qq_params_variants_id_qq` (`id_qq`);

ALTER TABLE `iv_qq_params_variants` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_qq_params_variants` ADD CONSTRAINT `fk_iv_qq_params_variants_id_qq` FOREIGN KEY (`id_qq`) REFERENCES `iv_qq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
