-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 19 2015 г., 10:07
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `tasklist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `task_list`
--

CREATE TABLE IF NOT EXISTS `task_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `descr` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `task_list`
--

INSERT INTO `task_list` (`id`, `projectId`, `descr`, `status`) VALUES
(1, 1, 'dine in the cafe', 0),
(2, 1, 'dadsfasdasdasdasd', 0),
(3, 1, 'go to the movies', 0),
(4, 1, 'work in the house', 0),
(5, 5, '444', 0),
(7, 1, '', 0),
(8, 1, 'go to the store', 0),
(10, 9, 'asdasdsad', 0),
(11, 7, 'adasdsd', 0),
(21, 7, '1111111', 0),
(22, 7, '2222222', 0),
(23, 7, '33333', 0),
(24, 7, '33333', 0),
(25, 7, '44444', 0),
(26, 7, '666666', 0),
(27, 7, '77777', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `task_projects`
--

CREATE TABLE IF NOT EXISTS `task_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `task_projects`
--

INSERT INTO `task_projects` (`id`, `name`) VALUES
(1, 'tasks for the day'),
(7, 'gigou'),
(9, 'dsadasdsad');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
