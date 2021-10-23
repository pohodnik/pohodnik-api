
-- --------------------------------------------------------

--
-- Структура таблицы `route_icons_svg`
--

CREATE TABLE `route_icons_svg` (
  `id` int(11) NOT NULL,
  `name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `viewBox` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `paths` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `route_icons_svg` ADD PRIMARY KEY (`id`);

ALTER TABLE `route_icons_svg` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
