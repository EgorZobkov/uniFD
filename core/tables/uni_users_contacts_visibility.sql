SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_users_contacts_visibility` (
  `user_id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telegram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `show_email` tinyint(1) NOT NULL DEFAULT '0',
  `show_phone` tinyint(1) NOT NULL DEFAULT '0',
  `show_telegram` tinyint(1) NOT NULL DEFAULT '0',
  `show_vk` tinyint(1) NOT NULL DEFAULT '0',
  `verified_email` tinyint(1) NOT NULL DEFAULT '0',
  `verified_phone` tinyint(1) NOT NULL DEFAULT '0',
  `verified_telegram` tinyint(1) NOT NULL DEFAULT '0',
  `verified_vk` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_users_contacts_visibility`
--
ALTER TABLE `uni_users_contacts_visibility`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `show_email` (`show_email`),
  ADD KEY `show_phone` (`show_phone`),
  ADD KEY `show_telegram` (`show_telegram`),
  ADD KEY `show_vk` (`show_vk`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;