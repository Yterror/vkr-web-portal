-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: sql111.infinityfree.com
-- Время создания: Авг 13 2026 г., 19:57
-- Версия сервера: 11.4.12-MariaDB
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `if0_42624008_webportal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answer_options`
--

CREATE TABLE `answer_options` (
  `OPT_ID` int(11) NOT NULL,
  `OPT_QST_ID` int(11) NOT NULL,
  `OPT_TEXT` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `CAT_ID` int(11) NOT NULL,
  `CAT_NAME` varchar(100) NOT NULL,
  `CAT_DESCRIPTION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `NOT_ID` int(11) NOT NULL,
  `NOT_USER_ID` int(11) NOT NULL,
  `NOT_TEXT` text NOT NULL,
  `NOT_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `NOT_STATUS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

CREATE TABLE `polls` (
  `POLL_ID` int(11) NOT NULL,
  `POLL_TITLE` varchar(150) NOT NULL,
  `POLL_DESCRIPTION` text DEFAULT NULL,
  `POLL_START_DATE` date NOT NULL,
  `POLL_END_DATE` date NOT NULL,
  `POLL_STATUS` varchar(30) NOT NULL,
  `POLL_CAT_ID` int(11) NOT NULL,
  `POLL_USER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_participants`
--

CREATE TABLE `poll_participants` (
  `PART_ID` int(11) NOT NULL,
  `PART_USER_ID` int(11) NOT NULL,
  `PART_POLL_ID` int(11) NOT NULL,
  `PART_STATUS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `QST_ID` int(11) NOT NULL,
  `QST_POLL_ID` int(11) NOT NULL,
  `QST_TEXT` text NOT NULL,
  `QST_TYPE` varchar(30) NOT NULL,
  `QST_ORDER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `RES_ID` int(11) NOT NULL,
  `RES_POLL_ID` int(11) NOT NULL,
  `RES_TOTAL_USERS` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `ROLE_ID` int(11) NOT NULL,
  `ROLE_NAME` varchar(50) NOT NULL,
  `ROLE_DESCRIPTION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`ROLE_ID`, `ROLE_NAME`, `ROLE_DESCRIPTION`) VALUES
(1, 'Администратор', 'Полный доступ к системе'),
(2, 'Преподаватель', 'Создание опросов и просмотр результатов'),
(3, 'Студент', 'Прохождение доступных опросов');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `USER_ROLE_ID` int(11) NOT NULL,
  `USER_FULL_NAME` varchar(150) NOT NULL,
  `USER_EMAIL` varchar(100) NOT NULL,
  `USER_PASSWORD` varchar(255) NOT NULL,
  `USER_REG_DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

CREATE TABLE `user_answers` (
  `ANS_ID` int(11) NOT NULL,
  `ANS_USER_ID` int(11) NOT NULL,
  `ANS_OPT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`OPT_ID`),
  ADD KEY `FK_OPTIONS_QUESTION` (`OPT_QST_ID`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CAT_ID`),
  ADD UNIQUE KEY `UK_CAT_NAME` (`CAT_NAME`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NOT_ID`),
  ADD KEY `FK_NOTIFICATIONS_USER` (`NOT_USER_ID`);

--
-- Индексы таблицы `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`POLL_ID`),
  ADD KEY `FK_POLLS_CATEGORY` (`POLL_CAT_ID`),
  ADD KEY `FK_POLLS_USER` (`POLL_USER_ID`);

--
-- Индексы таблицы `poll_participants`
--
ALTER TABLE `poll_participants`
  ADD PRIMARY KEY (`PART_ID`),
  ADD UNIQUE KEY `UK_PARTICIPANT_POLL` (`PART_USER_ID`,`PART_POLL_ID`),
  ADD KEY `FK_PARTICIPANTS_POLL` (`PART_POLL_ID`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QST_ID`),
  ADD KEY `FK_QUESTIONS_POLL` (`QST_POLL_ID`);

--
-- Индексы таблицы `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`RES_ID`),
  ADD KEY `FK_RESULTS_POLL` (`RES_POLL_ID`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ROLE_ID`),
  ADD UNIQUE KEY `UK_ROLE_NAME` (`ROLE_NAME`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `UK_USER_EMAIL` (`USER_EMAIL`),
  ADD KEY `FK_USERS_ROLE` (`USER_ROLE_ID`);

--
-- Индексы таблицы `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`ANS_ID`),
  ADD KEY `FK_ANSWERS_USER` (`ANS_USER_ID`),
  ADD KEY `FK_ANSWERS_OPTION` (`ANS_OPT_ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `OPT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `CAT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NOT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `POLL_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `poll_participants`
--
ALTER TABLE `poll_participants`
  MODIFY `PART_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `QST_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `results`
--
ALTER TABLE `results`
  MODIFY `RES_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `ANS_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answer_options`
--
ALTER TABLE `answer_options`
  ADD CONSTRAINT `FK_OPTIONS_QUESTION` FOREIGN KEY (`OPT_QST_ID`) REFERENCES `questions` (`QST_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_NOTIFICATIONS_USER` FOREIGN KEY (`NOT_USER_ID`) REFERENCES `users` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `FK_POLLS_CATEGORY` FOREIGN KEY (`POLL_CAT_ID`) REFERENCES `categories` (`CAT_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_POLLS_USER` FOREIGN KEY (`POLL_USER_ID`) REFERENCES `users` (`USER_ID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poll_participants`
--
ALTER TABLE `poll_participants`
  ADD CONSTRAINT `FK_PARTICIPANTS_POLL` FOREIGN KEY (`PART_POLL_ID`) REFERENCES `polls` (`POLL_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PARTICIPANTS_USER` FOREIGN KEY (`PART_USER_ID`) REFERENCES `users` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_QUESTIONS_POLL` FOREIGN KEY (`QST_POLL_ID`) REFERENCES `polls` (`POLL_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `FK_RESULTS_POLL` FOREIGN KEY (`RES_POLL_ID`) REFERENCES `polls` (`POLL_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_USERS_ROLE` FOREIGN KEY (`USER_ROLE_ID`) REFERENCES `roles` (`ROLE_ID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `FK_ANSWERS_OPTION` FOREIGN KEY (`ANS_OPT_ID`) REFERENCES `answer_options` (`OPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ANSWERS_USER` FOREIGN KEY (`ANS_USER_ID`) REFERENCES `users` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
