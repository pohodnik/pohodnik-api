
-- --------------------------------------------------------

--
-- Структура таблицы `route_editors`
--

CREATE TABLE `route_editors` (
  `id` int(9) NOT NULL,
  `id_route` int(9) NOT NULL,
  `id_user` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `route_editors` ADD PRIMARY KEY (`id`), ADD KEY `fk_route_editors_id_route` (`id_user`), ADD KEY `fk_route_editors_route` (`id_route`);

ALTER TABLE `route_editors` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `route_editors` ADD CONSTRAINT `fk_route_editors_route` FOREIGN KEY (`id_route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_route_editors_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
