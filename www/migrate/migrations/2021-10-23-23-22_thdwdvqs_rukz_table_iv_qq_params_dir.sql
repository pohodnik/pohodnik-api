
-- --------------------------------------------------------

--
-- Структура таблицы `iv_qq_params_dir`
--

CREATE TABLE `iv_qq_params_dir` (
  `id` int(9) NOT NULL,
  `id_qq` int(9) NOT NULL,
  `id_dir` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Настрйоки параметров справочникоы';

ALTER TABLE `iv_qq_params_dir` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_qq_params_dir_id_qq` (`id_qq`), ADD KEY `fk_iv_qq_params_dir_id_dir` (`id_dir`);

ALTER TABLE `iv_qq_params_dir` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_qq_params_dir` ADD CONSTRAINT `fk_iv_qq_params_dir_id_dir` FOREIGN KEY (`id_dir`) REFERENCES `iv_directories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_iv_qq_params_dir_id_qq` FOREIGN KEY (`id_qq`) REFERENCES `iv_qq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
