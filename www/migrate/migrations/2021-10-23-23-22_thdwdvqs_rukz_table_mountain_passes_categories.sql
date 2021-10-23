
-- --------------------------------------------------------

--
-- Структура таблицы `mountain_passes_categories`
--

CREATE TABLE `mountain_passes_categories` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(7) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории горных перевалов';

ALTER TABLE `mountain_passes_categories` ADD PRIMARY KEY (`id`);

ALTER TABLE `mountain_passes_categories` MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;
