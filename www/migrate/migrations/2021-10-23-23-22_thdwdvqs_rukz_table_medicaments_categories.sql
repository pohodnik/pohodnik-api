
-- --------------------------------------------------------

--
-- Структура таблицы `medicaments_categories`
--

CREATE TABLE `medicaments_categories` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `medicaments_categories` ADD PRIMARY KEY (`id`);

ALTER TABLE `medicaments_categories` MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
