-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 11 2020 г., 19:09
-- Версия сервера: 8.0.17
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `forumedia`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`, `email`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'uniquesitemailtest@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `surname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `club_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `login`, `password`, `email`, `name`, `surname`, `phone`, `image`, `address`, `active`, `club_type`) VALUES
(26, 'Pavlov', '0b8af62ab0caa8f2af33374473405cdc', 'vikkiners@yandex.ru', 'Виктор', 'Павлов', '+7 (999) 796-05-71', 'php78A3.tmp', 'Tula', 1, 'max'),
(28, 'Pakulin', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Геннадий', 'Пакулин', '+7 (789) 787-99-55', 'unknown.png', 'Тула', 0, 'standart'),
(30, 'Prevezencev', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Олег', 'Превезенцев', '+7 (111) 111-11-11', 'phpD0F6.tmp', 'Париж', 1, 'standart'),
(34, 'PetrovaM', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Мария', 'Петрова', '+7 (999) 852-36-97', 'php499.tmp', 'Милан', 1, 'standart'),
(39, 'Panteleeva', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Ксения', 'Пантелеева', '+7 (444) 444-44-44', 'php39B4.tmp', 'Коломбо', 1, 'max'),
(40, 'Panova', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Вероника', 'Панова', '+7 (111) 111-11-11', 'php896B.tmp', 'Москва', 0, 'no'),
(41, 'Perevozov', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Артем', 'Перевозов', '+7 (666) 666-66-66', 'phpBF9F.tmp', 'Магадан', 0, 'standart'),
(42, 'Pastuhov', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Иосиф', 'Пастухов', '+7 (999) 999-99-99', 'unknown.png', 'Дубай', 0, 'no'),
(43, 'Vasilev', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Роман', 'Васильев', '+7 (888) 888-88-88', 'unknown.png', 'Санто-Доминго', 0, 'no'),
(49, 'Vysockiy', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Владимир', 'Высоцкий', '+7 (222) 222-22-22', 'unknown.png', 'Москва', 1, 'no'),
(50, 'Weinstein', 'e10adc3949ba59abbe56e057f20f883e', 'vikkiners@yandex.ru', 'Харви', 'Вайнштейн', '+7 (111) 111-11-11', 'unknown.png', 'Калифорния', 1, 'max');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
