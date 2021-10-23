
-- --------------------------------------------------------

--
-- Структура таблицы `user_subscribes_regions`
--

CREATE TABLE `user_subscribes_regions` (
  `id` int(9) NOT NULL,
  `id_subs` int(9) NOT NULL,
  `id_region` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_subscribes_regions` ADD PRIMARY KEY (`id`), ADD KEY `user_subscribes_regions_fk_region` (`id_region`), ADD KEY `user_subscribes_regions_fk_subs` (`id_subs`);

ALTER TABLE `user_subscribes_regions` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_subscribes_regions` ADD CONSTRAINT `user_subscribes_regions_fk_region` FOREIGN KEY (`id_region`) REFERENCES `geo_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `user_subscribes_regions_fk_subs` FOREIGN KEY (`id_subs`) REFERENCES `user_subscribes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
