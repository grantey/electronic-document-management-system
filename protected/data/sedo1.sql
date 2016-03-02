-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_text` text,
  `order_data_from` date NOT NULL,
  `order_data_to` date NOT NULL,
  `order_type` int(11) NOT NULL,
  `order_group` int(11) DEFAULT NULL,
  `order_status` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `order_to_user` (
  `otu_order_id` int(11) NOT NULL,
  `otu_user_id` int(11) NOT NULL,
  `otu_priority` int(11) NOT NULL,
  PRIMARY KEY (`otu_order_id`,`otu_user_id`),
  KEY `otu_user_id` (`otu_user_id`),
  CONSTRAINT `order_to_user_ibfk_2` FOREIGN KEY (`otu_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_to_user_ibfk_1` FOREIGN KEY (`otu_order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_login` varchar(50) NOT NULL COMMENT 'Логин',
  `user_password` varchar(50) NOT NULL COMMENT 'Пароль',
  `user_full_name` varchar(100) NOT NULL COMMENT 'ФИО',
  `user_post` varchar(100) NOT NULL COMMENT 'Должность',
  `user_phone` varchar(50) DEFAULT NULL COMMENT 'Телефон',
  `user_faculty` varchar(100) DEFAULT NULL COMMENT 'Факультет',
  `user_depart` varchar(100) DEFAULT NULL COMMENT 'Кафедра',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `emp_id` (`user_login`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_full_name`, `user_post`, `user_phone`, `user_faculty`, `user_depart`) VALUES
(1,	'bakulin',	'123',	'Бакулин Антон Викторович',	'Ректор',	'555-55-55',	'',	''),
(2,	'ivanov',	'123',	'Иванов Иван Иванович',	'Декан',	'456-97-35',	'Прикладной математики и телекоммуникаций',	'Прикладной математики'),
(3,	'kazakova',	'123',	'Казакова Елена Дмитриевна',	'Секретарь',	'55-66-787',	'Автоматики и вычислительной техники',	'Машиностроения'),
(4,	'petrov',	'123',	'Петров Петр Петрович',	'Охранник',	'22-22-222',	'',	''),
(5,	'sergeev',	'123',	'Сергеев Сергей Сергеевич',	'Старший преподаватель',	'45-97-54',	'Автоматики и вычислительной техники',	'Машиностроения');

-- 2015-02-05 16:10:08
