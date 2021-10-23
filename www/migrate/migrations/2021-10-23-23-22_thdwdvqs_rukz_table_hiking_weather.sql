
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_weather`
--

CREATE TABLE `hiking_weather` (
  `id` int(9) NOT NULL,
  `id_hiking` int(9) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `lat` float(9,5) NOT NULL,
  `lon` float(9,5) NOT NULL,
  `forecast` text NOT NULL,
  `hourly_forecast` text COMMENT 'почасовой прогноз',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Погода для похода';

ALTER TABLE `hiking_weather` ADD PRIMARY KEY (`id`), ADD KEY `hiking_weather_id_hiking` (`id_hiking`);

ALTER TABLE `hiking_weather` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_weather` ADD CONSTRAINT `hiking_weather_id_hiking` FOREIGN KEY (`id_hiking`) REFERENCES `hiking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
