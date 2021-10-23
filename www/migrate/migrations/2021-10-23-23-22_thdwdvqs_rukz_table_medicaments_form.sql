
-- --------------------------------------------------------

--
-- Структура таблицы `medicaments_form`
--

CREATE TABLE `medicaments_form` (
  `id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `medicaments_form` ADD PRIMARY KEY (`id`);

ALTER TABLE `medicaments_form` MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
