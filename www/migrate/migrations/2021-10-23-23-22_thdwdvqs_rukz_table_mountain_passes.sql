
-- --------------------------------------------------------

--
-- Структура таблицы `mountain_passes`
--

CREATE TABLE `mountain_passes` (
  `id` int(11) NOT NULL,
  `name` varchar(96) NOT NULL,
  `coordinates` point NOT NULL,
  `altitude` int(11) NOT NULL,
  `id_pass_category` tinyint(2) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Горные перевалы';

ALTER TABLE `mountain_passes` ADD PRIMARY KEY (`id`), ADD KEY `mountain_passes_category_pk` (`id_pass_category`), ADD KEY `mountain_passes_author_pk` (`id_author`);

ALTER TABLE `mountain_passes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mountain_passes` ADD CONSTRAINT `mountain_passes_author_pk` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`), ADD CONSTRAINT `mountain_passes_category_pk` FOREIGN KEY (`id_pass_category`) REFERENCES `mountain_passes_categories` (`id`);
