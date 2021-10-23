
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_first_aid_kit`
--

CREATE TABLE `hiking_first_aid_kit` (
  `id` int(11) NOT NULL,
  `id_hiking` int(11) NOT NULL COMMENT 'id похода',
  `id_medicament` int(8) NOT NULL COMMENT 'id конкретного лекарства, входящего в аптечку',
  `amount` int(3) NOT NULL COMMENT 'количество лекарства',
  `id_author` int(11) NOT NULL COMMENT 'id автора',
  `comment` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата добавления медикамента в аптечку'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Аптечка для конкретного похода';

ALTER TABLE `hiking_first_aid_kit` ADD PRIMARY KEY (`id`), ADD KEY `hiking_med_id_fk` (`id_medicament`), ADD KEY `hiking_id_fk` (`id_hiking`), ADD KEY `hiking_med_author_id_fk` (`id_author`);

ALTER TABLE `hiking_first_aid_kit` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_first_aid_kit` ADD CONSTRAINT `hiking_id_fk` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_med_author_id_fk` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `hiking_med_id_fk` FOREIGN KEY (`id_medicament`) REFERENCES `medicaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
