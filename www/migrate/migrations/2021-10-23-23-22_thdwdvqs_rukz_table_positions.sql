
-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `desc_before` text NOT NULL COMMENT 'Перед походом',
  `desc_during` text NOT NULL COMMENT 'Во время похода',
  `desc_after` text NOT NULL COMMENT 'После похода'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Должности участников похода';

ALTER TABLE `positions` ADD PRIMARY KEY (`id`);

ALTER TABLE `positions` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
