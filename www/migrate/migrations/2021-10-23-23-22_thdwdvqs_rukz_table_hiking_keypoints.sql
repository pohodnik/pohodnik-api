
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_keypoints`
--

CREATE TABLE `hiking_keypoints` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ключевые точки похода';

ALTER TABLE `hiking_keypoints` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_keypoints_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_keypoints` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_keypoints` ADD CONSTRAINT `fk_hiking_keypoints_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
