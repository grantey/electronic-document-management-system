-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 29 2016 г., 16:43
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sedo1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_user_id` int(11) DEFAULT NULL,
  `app_text` text,
  `app_resolution` int(11) NOT NULL,
  `app_date` date DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  KEY `app_order_id` (`app_id`),
  KEY `app_user_id` (`app_user_id`),
  KEY `app_resolution` (`app_resolution`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `application`
--

INSERT INTO `application` (`app_id`, `app_user_id`, `app_text`, `app_resolution`, `app_date`) VALUES
(22, NULL, 'Отправляю документ 31 на рассмотрение трем людям: \r\nИванову Ивану Ивановичу\r\nПетрову Петру Петровичу\r\nСергееву Сергею Сергеевичу', 6, '2015-02-28'),
(26, NULL, 'Сдвинем дату на неделю и отправим троим', 6, '2015-04-09'),
(30, NULL, 'Сергеев тоже готов !!!', 1, '2015-03-31'),
(32, NULL, '47 был отправлен троим, я один из них. напишу ка я резолюцию, а те два не будут пока писать, посмотрим как это будет выглядеть у отправителя(бакулина антона)', 7, '2015-04-17'),
(33, NULL, 'Казакова выполнила документ 31', 1, NULL),
(37, NULL, 'Резолюция к 30му документу', 1, '2015-03-19'),
(41, NULL, '', 1, '2015-04-09'),
(42, NULL, 'Выполнить финальный тест 1', 6, '2015-04-27'),
(43, NULL, 'Отчет о выполнении финального теста Петровым', 2, '2015-04-13'),
(44, NULL, '', 1, '2015-04-16');

-- --------------------------------------------------------

--
-- Структура таблицы `archive`
--

CREATE TABLE IF NOT EXISTS `archive` (
  `a_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_order_header` varchar(200) NOT NULL,
  `a_order_text` text,
  `a_order_data_from` date NOT NULL,
  `a_order_data_to` date NOT NULL,
  `a_order_type` int(11) NOT NULL,
  `a_order_status` int(11) NOT NULL,
  `a_user_id` int(11) NOT NULL,
  `a_date` date NOT NULL,
  PRIMARY KEY (`a_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Дамп данных таблицы `archive`
--

INSERT INTO `archive` (`a_order_id`, `a_order_header`, `a_order_text`, `a_order_data_from`, `a_order_data_to`, `a_order_type`, `a_order_status`, `a_user_id`, `a_date`) VALUES
(4, 'Заголовок документа 4', 'Это просто пример документа, отправленного Бакулиным А.В.', '2025-02-20', '2025-03-20', 1, 6, 4, '2015-06-18'),
(7, 'Заголовок документа 7', 'Это уже третий документ !!!', '2025-02-20', '2020-02-20', 6, 6, 2, '2015-06-18'),
(31, 'Пятый документ Бакулина АВ', 'Текст пятого документа', '2025-02-20', '2022-02-20', 9, 6, 2, '2015-06-18'),
(55, 'Тестирование дат 2', 'Тестирование дат 2 тттттттттттттт', '2027-03-20', '2027-03-20', 7, 6, 1, '2016-01-11'),
(58, 'Заголовок документа 4', 'Это просто пример документа, отправленного Бакулиным А.В.', '2025-02-20', '2025-03-20', 1, 6, 1, '2015-05-10'),
(59, 'Заголовок документа 4', 'Это просто пример документа, отправленного Бакулиным А.В.', '2025-02-20', '2025-03-20', 1, 6, 1, '2015-04-07'),
(60, 'Тестирование дат 2 копия', 'Тестирование дат 2 тттттттттттттт', '2027-03-20', '2008-04-20', 7, 6, 2, '2015-06-18'),
(61, 'Заголовок документа 4', 'Это просто пример документа, отправленного Бакулиным А.В.', '2025-02-20', '2025-03-20', 1, 6, 1, '2015-04-07');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_type` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`category_id`, `category_type`) VALUES
(1, 'Договор'),
(2, 'Докладная записка'),
(3, 'Заявка'),
(4, 'Опись'),
(5, 'План'),
(6, 'Платеж'),
(7, 'Приказ'),
(8, 'Распоряжение'),
(9, 'Служебная записка'),
(10, 'Счет');

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_path` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`file_id`, `file_path`, `file_name`, `file_upload_date`) VALUES
(19, 'W:\\domains\\yii-sedo\\protected\\uploads', 'IMG_20150202_153906 (1).jpg', '2015-02-24 09:35:52'),
(20, 'W:\\domains\\yii-sedo\\protected\\uploads', '5127456.jpg', '2015-04-05 11:27:01'),
(21, 'W:\\domains\\yii-sedo\\protected\\uploads', 'images (1).jpg', '2015-04-05 11:27:01');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_header` varchar(200) NOT NULL,
  `order_text` text COMMENT 'Текст документа',
  `order_data_from` date NOT NULL COMMENT 'Дата отправки',
  `order_data_to` date NOT NULL COMMENT 'Выполнить до',
  `order_type` int(11) NOT NULL COMMENT 'Тип документа',
  `order_status` int(11) NOT NULL COMMENT 'Физический статус',
  PRIMARY KEY (`order_id`),
  KEY `order_type` (`order_type`),
  KEY `order_status` (`order_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `order_header`, `order_text`, `order_data_from`, `order_data_to`, `order_type`, `order_status`) VALUES
(4, 'Заголовок документа 4', 'Это просто пример документа, отправленного Бакулиным А.В.', '2015-02-25', '2015-03-25', 1, 6),
(5, 'Заголовок документа 5', 'Еще один документ.', '2015-02-25', '2015-02-09', 1, 6),
(6, 'Заголовок документа 6', 'Документ Администратора', '2015-02-25', '2015-02-28', 2, 6),
(7, 'Заголовок документа 7', 'Это уже третий документ !!!', '2015-02-25', '2015-02-20', 6, 6),
(30, 'Документ с двумя прикрепленными файлами', 'Это просто пример документа с двумя прикрепленным и файлами. Сейчас мы будем тестировать отображение файлов в подробном описании документа', '2015-04-06', '2015-04-23', 7, 6),
(31, 'Пятый документ Бакулина АВ', 'Текст пятого документа', '2015-02-25', '2015-02-22', 9, 6),
(47, 'Тестирование дат', 'Тест дат', '2015-03-27', '2015-04-15', 8, 6),
(49, 'Тестирование дат 2', 'Тестирование дат 2 тттттттттттттт', '2015-03-27', '2015-04-08', 2, 6),
(50, 'Новый документ Иванова Ивана', 'некоторый текст', '2015-03-29', '2015-04-30', 2, 6),
(56, 'Тестирование дат 2', 'Тестирование дат 2 тттттттттттттт', '2015-03-27', '2015-04-08', 7, 6),
(60, 'Тестирование дат 2 копия', 'Тестирование дат 2 тттттттттттттт', '2015-03-27', '2015-04-08', 7, 6),
(61, 'Финальный тест 1', '', '2015-04-13', '2015-04-25', 1, 6),
(62, 'Тестирование дат 2', 'Тестирование дат 2 тттттттттттттт', '2015-03-27', '2015-04-08', 7, 6),
(63, 'Тестирование дат 2', 'Тестирование дат 2 тттттттттттттт', '2015-03-27', '2015-04-08', 7, 6),
(64, 'Документ петрова', '', '2015-05-06', '2015-05-13', 2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `order_file`
--

CREATE TABLE IF NOT EXISTS `order_file` (
  `of_order_id` int(11) NOT NULL,
  `of_file_id` int(11) NOT NULL,
  KEY `of_order_id` (`of_order_id`),
  KEY `of_file_id` (`of_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_file`
--

INSERT INTO `order_file` (`of_order_id`, `of_file_id`) VALUES
(30, 20),
(30, 21);

-- --------------------------------------------------------

--
-- Структура таблицы `receivers`
--

CREATE TABLE IF NOT EXISTS `receivers` (
  `receiver_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_order_id` int(11) NOT NULL,
  `receiver_from` int(11) NOT NULL,
  `receiver_to` int(11) NOT NULL,
  PRIMARY KEY (`receiver_id`),
  KEY `receiver_order_id` (`receiver_order_id`),
  KEY `receiver_from` (`receiver_from`),
  KEY `receiver_to` (`receiver_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `receivers`
--

INSERT INTO `receivers` (`receiver_id`, `receiver_order_id`, `receiver_from`, `receiver_to`) VALUES
(33, 30, 1, 5),
(34, 30, 1, 7),
(35, 30, 1, 8),
(40, 47, 1, 2),
(41, 47, 1, 3),
(43, 47, 1, 8),
(44, 7, 1, 2),
(45, 31, 1, 2),
(46, 31, 1, 4),
(47, 31, 1, 5),
(51, 56, 1, 2),
(52, 60, 1, 5),
(55, 60, 1, 2),
(56, 60, 1, 3),
(57, 61, 1, 4),
(58, 61, 1, 5),
(59, 62, 1, 2),
(60, 62, 1, 3),
(61, 62, 1, 4),
(62, 63, 2, 3),
(63, 63, 2, 4),
(64, 63, 2, 5),
(66, 56, 2, 4),
(67, 56, 4, 2),
(68, 49, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `resolution`
--

CREATE TABLE IF NOT EXISTS `resolution` (
  `resolution_id` int(11) NOT NULL AUTO_INCREMENT,
  `resolution_type` varchar(30) NOT NULL,
  PRIMARY KEY (`resolution_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `resolution`
--

INSERT INTO `resolution` (`resolution_id`, `resolution_type`) VALUES
(1, 'Не возражаю'),
(2, 'К исполнению'),
(3, 'В архив'),
(4, 'Отказать'),
(6, 'Подготовить план работы'),
(7, 'Считаю нецелесообразным');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `set_user_id` int(11) NOT NULL,
  `set_alert` int(11) NOT NULL DEFAULT '2',
  `set_archive` int(11) NOT NULL DEFAULT '30',
  `set_old` int(11) NOT NULL,
  `set_auto` tinyint(1) NOT NULL,
  PRIMARY KEY (`set_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`set_user_id`, `set_alert`, `set_archive`, `set_old`, `set_auto`) VALUES
(1, 3, 30, 90, 1),
(2, 2, 30, 90, 0),
(3, 2, 30, 90, 0),
(4, 2, 30, 90, 0),
(5, 2, 30, 90, 0),
(7, 2, 30, 90, 0),
(8, 2, 30, 90, 0),
(25, 2, 30, 90, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_type` varchar(20) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`status_id`, `status_type`) VALUES
(1, 'Ознакомлено'),
(2, 'Выполнено'),
(3, 'Согласовано'),
(4, 'Доведено до сведения'),
(5, 'Невозможно'),
(6, 'К исполнению');

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_owner_id` int(11) NOT NULL,
  `template_title` varchar(100) NOT NULL,
  PRIMARY KEY (`template_id`),
  KEY `template_owner_id` (`template_owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `templates`
--

INSERT INTO `templates` (`template_id`, `template_owner_id`, `template_title`) VALUES
(1, 1, 'Кафедра автоматики'),
(3, 2, 'Шаблон Иванова'),
(5, 1, 'Ректорат'),
(6, 1, 'Отдел интеллектуальной собственности');

-- --------------------------------------------------------

--
-- Структура таблицы `templ_user`
--

CREATE TABLE IF NOT EXISTS `templ_user` (
  `tu_template_id` int(11) NOT NULL,
  `tu_user_id` int(11) NOT NULL,
  KEY `tu_template_id` (`tu_template_id`),
  KEY `tu_user_id` (`tu_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `templ_user`
--

INSERT INTO `templ_user` (`tu_template_id`, `tu_user_id`) VALUES
(1, 3),
(3, 1),
(5, 5),
(5, 2),
(5, 3),
(6, 4),
(6, 5),
(1, 5),
(1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `trace`
--

CREATE TABLE IF NOT EXISTS `trace` (
  `trace_id` int(11) NOT NULL AUTO_INCREMENT,
  `trace_order_id` int(11) NOT NULL COMMENT 'id документа',
  `trace_user_to` int(11) NOT NULL COMMENT 'id пользователя',
  `trace_user_from` int(11) DEFAULT NULL,
  `trace_order_lstatus` varchar(20) NOT NULL COMMENT 'Логический статус',
  `trace_app_id` int(11) DEFAULT NULL COMMENT 'ссылка на приложение',
  `trace_date_to` date NOT NULL COMMENT 'срок исполнения',
  `trace_date` date NOT NULL COMMENT 'дата изменения статуса',
  `trace_time` int(11) DEFAULT NULL COMMENT 'хранение в текущем статусе',
  `trace_done_mode` tinyint(1) NOT NULL COMMENT '0 - все 1 - любой',
  PRIMARY KEY (`trace_id`),
  KEY `history_order_id` (`trace_order_id`,`trace_user_to`,`trace_order_lstatus`),
  KEY `history_user_id` (`trace_user_to`),
  KEY `history_order_status` (`trace_order_lstatus`),
  KEY `history_user_from` (`trace_user_from`),
  KEY `trace_app_id` (`trace_app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Дамп данных таблицы `trace`
--

INSERT INTO `trace` (`trace_id`, `trace_order_id`, `trace_user_to`, `trace_user_from`, `trace_order_lstatus`, `trace_app_id`, `trace_date_to`, `trace_date`, `trace_time`, `trace_done_mode`) VALUES
(3, 6, 7, NULL, 'Новый', NULL, '2015-02-25', '0000-00-00', NULL, 0),
(5, 30, 1, NULL, 'Новый', 37, '2015-04-23', '0000-00-00', NULL, 0),
(6, 31, 1, NULL, 'В работе', 22, '2015-02-25', '0000-00-00', NULL, 0),
(7, 47, 1, NULL, 'В работе', 26, '2015-04-15', '0000-00-00', NULL, 0),
(9, 49, 1, NULL, 'Новый', NULL, '2008-04-20', '2027-03-20', NULL, 0),
(21, 47, 2, 1, 'В работе', 32, '2015-04-09', '0000-00-00', NULL, 0),
(22, 47, 3, 1, 'Новый', NULL, '2015-04-09', '0000-00-00', NULL, 0),
(23, 47, 8, 1, 'Новый', NULL, '2015-04-09', '0000-00-00', NULL, 0),
(25, 4, 5, 1, 'На хранении', 30, '2015-02-27', '2015-06-18', 30, 0),
(28, 31, 4, 1, 'Новый', NULL, '2015-02-28', '0000-00-00', NULL, 0),
(29, 31, 5, 1, 'Новый', NULL, '2015-02-28', '0000-00-00', NULL, 0),
(32, 31, 3, 2, 'На хранении', 33, '2015-02-28', '2015-06-18', 30, 0),
(33, 47, 4, 2, 'Новый', NULL, '2015-04-17', '0000-00-00', NULL, 0),
(37, 56, 1, NULL, 'В работе', NULL, '2015-04-08', '0000-00-00', NULL, 0),
(38, 56, 2, 1, 'В работе', NULL, '2015-04-08', '2015-05-12', NULL, 0),
(42, 60, 1, NULL, 'На хранении', NULL, '2008-04-20', '2016-01-11', 30, 1),
(54, 60, 5, 1, 'Новый', NULL, '2008-04-20', '2015-04-08', NULL, 0),
(56, 60, 3, 1, 'Исполнен', 41, '2008-04-20', '2015-04-09', 90, 0),
(57, 61, 1, NULL, 'На хранении', 42, '2015-04-25', '2016-01-11', 30, 1),
(58, 61, 4, 1, 'Исполнен', 43, '2015-04-27', '2015-04-13', 90, 0),
(59, 61, 5, 1, 'Новый', NULL, '2015-04-27', '2015-04-13', NULL, 0),
(60, 62, 1, NULL, 'В работе', NULL, '2015-04-08', '2015-04-16', NULL, 1),
(61, 62, 2, 1, 'На хранении', 44, '2015-04-08', '2015-08-07', 30, 0),
(62, 62, 3, 1, 'Исполнен', NULL, '2015-04-08', '2015-04-16', 90, 0),
(63, 62, 4, 1, 'Исполнен', NULL, '2015-04-08', '2015-04-16', 90, 0),
(64, 63, 2, 1, 'В работе', NULL, '2015-04-08', '2015-05-05', NULL, 0),
(65, 63, 3, 2, 'Новый', NULL, '2015-04-08', '2015-05-05', NULL, 0),
(66, 63, 4, 2, 'Новый', NULL, '2015-04-08', '2015-05-05', NULL, 0),
(67, 63, 5, 2, 'Новый', NULL, '2015-04-08', '2015-05-05', NULL, 0),
(68, 64, 4, NULL, 'Новый', NULL, '2015-05-13', '2015-05-06', NULL, 0),
(69, 56, 4, 2, 'Новый', NULL, '2015-04-08', '2015-05-12', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_login` varchar(50) NOT NULL COMMENT 'Логин',
  `user_password` varchar(50) NOT NULL COMMENT 'Пароль',
  `user_full_name` varchar(100) NOT NULL COMMENT 'ФИО',
  `user_post` varchar(100) NOT NULL COMMENT 'Должность',
  `user_phone` varchar(50) DEFAULT NULL COMMENT 'Телефон',
  `user_faculty` varchar(100) DEFAULT NULL COMMENT 'Факультет',
  `user_depart` varchar(100) DEFAULT NULL COMMENT 'Кафедра',
  `user_role` varchar(15) NOT NULL DEFAULT 'user' COMMENT '0 - админ, 1 - юзер, 2 - бан',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `emp_id` (`user_login`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_full_name`, `user_post`, `user_phone`, `user_faculty`, `user_depart`, `user_role`) VALUES
(1, 'bakulin', '123', 'Бакулин Антон Викторович', 'Преподаватель', '555-55-55', 'Прикладной математики и телекоммуникаций', '', 'user'),
(2, 'ivanov', '123', 'Иванов Иван Иванович', 'Декан', '456-97-35', 'Прикладной математики и телекоммуникаций', 'Прикладной математики', 'user'),
(3, 'kazakova', '123', 'Казакова Елена Дмитриевна', 'Секретарь', '55-66-787', 'Автоматики и вычислительной техники', 'Машиностроения', 'user'),
(4, 'petrov', '123', 'Петров Петр Петрович', 'Охранник', '22-22-222', '', '', 'user'),
(5, 'sergeev', '123', 'Сергеев Сергей Сергеевич', 'Старший преподаватель', '45-97-54', 'Автоматики и вычислительной техники', 'Машиностроения', 'user'),
(7, 'admin', 'admin', 'Морозов Георгий Юрьевич', 'Системный администратор', NULL, NULL, NULL, 'admin'),
(8, 'smirnova', '123', 'Смирнова Наталья', 'Старший преподаватель', '555-555-666', 'Автоматики и вычислительной техники', 'Автоматики', 'user'),
(25, 'demo', 'demo', 'Алексеев Петр Генадьевич', 'Преподаватель', '555-55-55', 'Прикладной математики и телекоммуникаций', 'Прикладной математики', 'user');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`app_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `application_ibfk_3` FOREIGN KEY (`app_resolution`) REFERENCES `resolution` (`resolution_id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`order_status`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_type`) REFERENCES `category` (`category_id`);

--
-- Ограничения внешнего ключа таблицы `order_file`
--
ALTER TABLE `order_file`
  ADD CONSTRAINT `order_file_ibfk_1` FOREIGN KEY (`of_order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_file_ibfk_2` FOREIGN KEY (`of_file_id`) REFERENCES `files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `receivers`
--
ALTER TABLE `receivers`
  ADD CONSTRAINT `receivers_ibfk_1` FOREIGN KEY (`receiver_order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `receivers_ibfk_2` FOREIGN KEY (`receiver_from`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `receivers_ibfk_3` FOREIGN KEY (`receiver_to`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`set_user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_ibfk_1` FOREIGN KEY (`template_owner_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `templ_user`
--
ALTER TABLE `templ_user`
  ADD CONSTRAINT `templ_user_ibfk_1` FOREIGN KEY (`tu_template_id`) REFERENCES `templates` (`template_id`),
  ADD CONSTRAINT `templ_user_ibfk_2` FOREIGN KEY (`tu_user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `trace`
--
ALTER TABLE `trace`
  ADD CONSTRAINT `trace_ibfk_1` FOREIGN KEY (`trace_order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `trace_ibfk_2` FOREIGN KEY (`trace_user_to`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `trace_ibfk_3` FOREIGN KEY (`trace_user_from`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `trace_ibfk_5` FOREIGN KEY (`trace_app_id`) REFERENCES `application` (`app_id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
