
-- --------------------------------------------------------

--
-- Структура таблицы `iv_ans_content`
--

CREATE TABLE `iv_ans_content` (
  `id` int(11) NOT NULL,
  `id_ans` int(11) NOT NULL,
  `v_from_input` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `v_from_variants` int(9) NOT NULL,
  `v_from_dir` int(11) NOT NULL,
  `v_custom` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Что-то ввел сам'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `iv_ans_content` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_ans_content_id_ans` (`id_ans`);

ALTER TABLE `iv_ans_content` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_ans_content` ADD CONSTRAINT `fk_iv_ans_content_id_ans` FOREIGN KEY (`id_ans`) REFERENCES `iv_ans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
