
-- --------------------------------------------------------

--
-- Структура таблицы `user_food_pref`
--

CREATE TABLE `user_food_pref` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_recipe` int(9) NOT NULL,
  `id_act` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Предпочтения пользователя по еде';

ALTER TABLE `user_food_pref` ADD PRIMARY KEY (`id`), ADD KEY `fk_user_user_food_pref_id_user` (`id_user`), ADD KEY `fk_user_user_food_pref_id_recipe` (`id_recipe`), ADD KEY `fk_user_user_food_pref_id_act` (`id_act`);

ALTER TABLE `user_food_pref` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_food_pref` ADD CONSTRAINT `fk_user_user_food_pref_id_act` FOREIGN KEY (`id_act`) REFERENCES `food_acts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_user_food_pref_id_recipe` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_user_food_pref_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
