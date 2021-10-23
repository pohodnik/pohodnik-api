
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_vacancies`
--

CREATE TABLE `hiking_vacancies` (
  `id` int(8) NOT NULL,
  `id_hiking` int(11) NOT NULL,
  `id_position` int(3) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='вакансии для похода';

ALTER TABLE `hiking_vacancies` ADD PRIMARY KEY (`id`), ADD KEY `id_hiking` (`id_hiking`), ADD KEY `vacancy_position_fk` (`id_position`);

ALTER TABLE `hiking_vacancies` MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_vacancies` ADD CONSTRAINT `vacancy_hiking_fk` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `vacancy_position_fk` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
