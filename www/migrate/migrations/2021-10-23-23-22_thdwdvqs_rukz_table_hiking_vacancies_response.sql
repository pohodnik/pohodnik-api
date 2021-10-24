
-- --------------------------------------------------------

--
-- Структура таблицы `hiking_vacancies_response`
--

CREATE TABLE `hiking_vacancies_response` (
  `id` int(11) NOT NULL,
  `id_hiking_vacancy` int(8) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `comment` varchar(255) NOT NULL DEFAULT '',
  `approve_user_id` int(11) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='отклик на вакансии похода';

ALTER TABLE `hiking_vacancies_response` ADD PRIMARY KEY (`id`), ADD KEY `fk_hiking_vacancies_response_id_hiking_vacancy` (`id_hiking_vacancy`), ADD KEY `hiking_vacancies_response_id_user_fk` (`id_user`), ADD KEY `hiking_vacancies_response_id_approver` (`approve_user_id`);

ALTER TABLE `hiking_vacancies_response` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `hiking_vacancies_response` ADD CONSTRAINT `fk_hiking_vacancies_response_id_hiking_vacancy` FOREIGN KEY (`id_hiking_vacancy`) REFERENCES `hiking_vacancies` (`id`), ADD CONSTRAINT `hiking_vacancies_response_id_approver` FOREIGN KEY (`approve_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE, ADD CONSTRAINT `hiking_vacancies_response_id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
