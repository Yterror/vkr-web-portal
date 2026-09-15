-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: sql111.infinityfree.com
-- Время создания: Сен 15 2026 г., 18:02
-- Версия сервера: 11.4.13-MariaDB
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

--
-- Дамп данных таблицы `answer_options`
--

INSERT INTO `answer_options` (`OPT_ID`, `OPT_QST_ID`, `OPT_TEXT`) VALUES
(1, 1, 'тест'),
(2, 1, 'тест'),
(3, 2, 'тест'),
(4, 2, 'тест'),
(5, 4, 'тест1'),
(6, 4, 'тест2'),
(7, 4, 'тест3'),
(8, 5, 'тест6'),
(9, 5, 'тест7'),
(10, 5, 'тест8'),
(11, 7, '5'),
(12, 7, '6'),
(13, 7, '7'),
(14, 8, '1'),
(15, 8, '2'),
(16, 8, '3');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `CAT_ID` int(11) NOT NULL,
  `CAT_NAME` varchar(100) NOT NULL,
  `CAT_DESCRIPTION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`CAT_ID`, `CAT_NAME`, `CAT_DESCRIPTION`) VALUES
(1, 'Учебный процесс', 'Опросы об организации учебного процесса'),
(2, 'Электронные сервисы', 'Опросы об электронных сервисах университета'),
(3, 'Студенческая жизнь', 'Опросы о жизни студентов'),
(4, 'Обратная связь', 'Общие опросы и предложения');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `FEEDBACK_ID` int(11) NOT NULL,
  `FEEDBACK_NAME` varchar(150) NOT NULL,
  `FEEDBACK_EMAIL` varchar(100) NOT NULL,
  `FEEDBACK_SUBJECT` varchar(150) NOT NULL,
  `FEEDBACK_MESSAGE` text NOT NULL,
  `FEEDBACK_DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`FEEDBACK_ID`, `FEEDBACK_NAME`, `FEEDBACK_EMAIL`, `FEEDBACK_SUBJECT`, `FEEDBACK_MESSAGE`, `FEEDBACK_DATE`) VALUES
(1, 'тест', 'test@bk.ru', 'тест', 'тест тест', '2026-08-21 13:52:55');

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

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`NOT_ID`, `NOT_USER_ID`, `NOT_TEXT`, `NOT_DATE`, `NOT_STATUS`) VALUES
(1, 1, 'Создан новый опрос: тест5', '2026-09-10 20:08:39', 'Новое');

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

--
-- Дамп данных таблицы `polls`
--

INSERT INTO `polls` (`POLL_ID`, `POLL_TITLE`, `POLL_DESCRIPTION`, `POLL_START_DATE`, `POLL_END_DATE`, `POLL_STATUS`, `POLL_CAT_ID`, `POLL_USER_ID`) VALUES
(1, 'тест', 'тест', '2026-08-17', '2026-08-18', 'Активен', 1, 1),
(2, 'тест', 'тест', '2026-08-18', '2026-08-19', 'Активен', 1, 1),
(3, 'тест 2', '123', '2026-09-01', '2026-09-30', 'Активен', 1, 2),
(4, 'тест5', 'тест7', '2026-09-10', '2026-09-11', 'Активен', 4, 2);

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

--
-- Дамп данных таблицы `poll_participants`
--

INSERT INTO `poll_participants` (`PART_ID`, `PART_USER_ID`, `PART_POLL_ID`, `PART_STATUS`) VALUES
(11, 1, 2, 'Завершен'),
(12, 1, 4, 'Завершен');

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

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`QST_ID`, `QST_POLL_ID`, `QST_TEXT`, `QST_TYPE`, `QST_ORDER`) VALUES
(1, 2, 'тест', 'Один вариант ответа', 1),
(2, 2, 'тест', 'Один вариант ответа', 2),
(3, 2, 'тест', 'Один вариант ответа', 3),
(4, 3, 'тест', 'Один вариант ответа', 1),
(5, 3, 'тест5', 'Один вариант ответа', 2),
(6, 3, 'тест', 'Текстовый ответ', 3),
(7, 4, 'тест 1', 'Один вариант ответа', 1),
(8, 4, 'тест 2', 'Один вариант ответа', 2),
(9, 4, 'тест', 'Один вариант ответа', 3);

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

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`USER_ID`, `USER_ROLE_ID`, `USER_FULL_NAME`, `USER_EMAIL`, `USER_PASSWORD`, `USER_REG_DATE`) VALUES
(1, 3, 'Иван Пупкин', 'test@mail.ru', '$2y$10$30HfQmjx/dFWZJRc18aaKevwVskNY/3psfCrtZA4JYyG5XOIc5I8.', '2026-08-14 07:04:50'),
(2, 2, 'Учитель', 'teacher@mail.ru', '$2y$10$TePZkguBw/I0x7J4lym.9er54D2JmKHkS9CKHIOzWma70JlKUwjc2', '2026-09-01 17:08:59'),
(3, 1, 'Админ', 'admin@mail.ru', '$2y$10$FJ5e1cwk1eF4QX0Lo4arVeOrWYWFn7cpUoivA8Dgzx55SJcdb2GYO', '2026-09-01 17:09:19');

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

CREATE TABLE `user_answers` (
  `ANS_ID` int(11) NOT NULL,
  `ANS_USER_ID` int(11) NOT NULL,
  `ANS_OPT_ID` int(11) NOT NULL,
  `ANS_TEXT` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_answers`
--

INSERT INTO `user_answers` (`ANS_ID`, `ANS_USER_ID`, `ANS_OPT_ID`, `ANS_TEXT`) VALUES
(9, 1, 4, NULL),
(10, 1, 8, NULL),
(12, 1, 16, NULL);

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
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FEEDBACK_ID`);

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
  MODIFY `OPT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `CAT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FEEDBACK_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NOT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `POLL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `poll_participants`
--
ALTER TABLE `poll_participants`
  MODIFY `PART_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `QST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `ANS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
