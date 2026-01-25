
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_chat_automessages` (
  `id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_chat_automessages`
--

INSERT INTO `uni_chat_automessages` (`id`, `text`, `action`) VALUES
(1, 'tr_d84730b83826e13aa13c43233aedbceb', 'system_registration'),
(2, 'tr_74ca6d07e9094493d1f47bac712d08e4', 'system_create_order'),
(3, 'tr_721d9070823721a1badb1f2b0bb7013b', 'system_warning_contacts'),
(4, 'tr_50b5de49815b252b9ac6bb5764cfe376', 'add_to_favorite'),
(5, 'tr_33a788cce95f22f5c5f3ba491baa5e3f', 'view_ad_contacts'),
(6, 'tr_710d906d1cc3ef9f111594ce3617db27', 'user_asks_review'),
(7, 'tr_19a9b1e64a88e50f87c4ddbec480d146', 'new_review'),
(8, 'tr_78813184fd42deb6b55f927400c65ee5', 'response_review'),
(9, 'tr_c6d5a1b4c4f769c9a3f1c0cbfcb429f3', 'first_message_support');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_chat_automessages`
--
ALTER TABLE `uni_chat_automessages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_chat_automessages`
--
ALTER TABLE `uni_chat_automessages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
