
-- --------------------------------------------------------

--
-- Структура таблицы `iv_directories_param`
--

CREATE TABLE `iv_directories_param` (
  `id` int(9) NOT NULL,
  `id_dir` int(3) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_equall` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Если 1 то равно иначе like(%%)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `iv_directories_param` ADD PRIMARY KEY (`id`), ADD KEY `fk_iv_directories_param_id_dir` (`id_dir`);

ALTER TABLE `iv_directories_param` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `iv_directories_param` ADD CONSTRAINT `fk_iv_directories_param_id_dir` FOREIGN KEY (`id_dir`) REFERENCES `iv_directories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
