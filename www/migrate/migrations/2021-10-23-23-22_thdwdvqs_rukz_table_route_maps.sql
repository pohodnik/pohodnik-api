
-- --------------------------------------------------------

--
-- Структура таблицы `route_maps`
--

CREATE TABLE `route_maps` (
  `id` int(3) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tileUrlTmpl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isElliptical` tinyint(1) NOT NULL DEFAULT '1',
  `subdomains` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `minZoom` int(2) NOT NULL DEFAULT '1',
  `maxZoom` int(2) NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `route_maps` ADD PRIMARY KEY (`id`);

ALTER TABLE `route_maps` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
