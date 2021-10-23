
-- --------------------------------------------------------

--
-- Структура таблицы `food_acts`
--

CREATE TABLE `food_acts` (
  `id` int(1) NOT NULL,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `time` time NOT NULL,
  `coeff_pct` int(2) NOT NULL,
  `norm_kkal` int(4) NOT NULL,
  `is_can_pref` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Признак собирать ли предпочтения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Акт приема пищи';

ALTER TABLE `food_acts` ADD PRIMARY KEY (`id`);

ALTER TABLE `food_acts` MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
