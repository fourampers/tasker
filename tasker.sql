-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 11 2020 г., 13:20
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tasker`
--
CREATE DATABASE IF NOT EXISTS `tasker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tasker`;

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--
-- Создание: Мар 09 2020 г., 11:20
-- Последнее обновление: Мар 09 2020 г., 17:32
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `salt`) VALUES
(1, 'admin', '1f876c3df4a79c6e0bd48eef1403bef1639b53555b9016338c250aa8395bbc06', '��LlƉ�������(�+�\ZjL�56��&');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--
-- Создание: Фев 29 2020 г., 11:54
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'выполняется'),
(2, 'выполнена');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--
-- Создание: Фев 29 2020 г., 11:53
-- Последнее обновление: Мар 10 2020 г., 21:42
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `edited` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--
-- Создание: Фев 29 2020 г., 15:37
-- Последнее обновление: Мар 10 2020 г., 21:42
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `v_admin`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `v_admin`;
CREATE TABLE `v_admin` (
`id` int(11)
,`user` varchar(50)
,`email` varchar(255)
,`content` text
,`created_at` datetime
,`status` varchar(255)
,`edited` tinyint(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `v_task`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `v_task`;
CREATE TABLE `v_task` (
`user` varchar(50)
,`email` varchar(255)
,`content` text
,`status` varchar(255)
);

-- --------------------------------------------------------

--
-- Структура для представления `v_admin`
--
DROP TABLE IF EXISTS `v_admin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_admin`  AS  select `task`.`id` AS `id`,`user`.`name` AS `user`,`user`.`email` AS `email`,`task`.`content` AS `content`,`task`.`created_at` AS `created_at`,`status`.`name` AS `status`,`task`.`edited` AS `edited` from ((`task` left join `user` on(`task`.`user_id` = `user`.`id`)) left join `status` on(`task`.`status_id` = `status`.`id`)) ;

-- --------------------------------------------------------

--
-- Структура для представления `v_task`
--
DROP TABLE IF EXISTS `v_task`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_task`  AS  select `user`.`name` AS `user`,`user`.`email` AS `email`,`task`.`content` AS `content`,`status`.`name` AS `status` from ((`task` left join `user` on(`task`.`user_id` = `user`.`id`)) left join `status` on(`task`.`status_id` = `status`.`id`)) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
