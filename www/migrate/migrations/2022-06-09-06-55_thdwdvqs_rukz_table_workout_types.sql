
-- --------------------------------------------------------

--
-- Структура таблицы `workout_types`
--

CREATE TABLE `workout_types` (
  `id` int(2) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `workout_types` ADD PRIMARY KEY (`id`);

ALTER TABLE `workout_types` MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `workouts` ADD `workout_type` INT(2) NULL DEFAULT NULL AFTER `date_update`;
ALTER TABLE `hiking_workouts_target` ADD `workout_type` INT(2) NULL DEFAULT NULL AFTER `description`;

ALTER TABLE `workouts` ADD CONSTRAINT `fk_workouts_workout_type` FOREIGN KEY (`workout_type`) REFERENCES `workout_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `hiking_workouts_target` ADD CONSTRAINT `fk_hiking_workouts_target_workout_type` FOREIGN KEY (`workout_type`) REFERENCES `workout_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
