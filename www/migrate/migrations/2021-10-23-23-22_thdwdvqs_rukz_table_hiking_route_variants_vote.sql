
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_route_variants_vote`
--

CREATE TABLE `hiking_route_variants_vote` (
  `id` int(9) NOT NULL,
  `id_variant` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `hiking_route_variants_vote` ADD PRIMARY KEY (`id`), ADD KEY `hiking_route_variants_vote_fk_user` (`id_user`), ADD KEY `hiking_route_variants_vote_fk_variant` (`id_variant`);

ALTER TABLE `hiking_route_variants_vote` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_route_variants_vote` ADD CONSTRAINT `hiking_route_variants_vote_fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `hiking_route_variants_vote_fk_variant` FOREIGN KEY (`id_variant`) REFERENCES `hiking_route_variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
