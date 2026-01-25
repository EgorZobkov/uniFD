
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_chat_messages` (
  `id` int NOT NULL,
  `from_user_id` int NOT NULL DEFAULT '0',
  `whom_user_id` int NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `time_create` timestamp NULL DEFAULT NULL,
  `media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` int NOT NULL DEFAULT '0',
  `channel_id` int NOT NULL DEFAULT '0',
  `admin` int NOT NULL DEFAULT '0',
  `dialogue_id` int NOT NULL DEFAULT '0',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `responder_id` int NOT NULL DEFAULT '0',
  `time_view` timestamp NULL DEFAULT NULL,
  `ad_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `delete_status` int NOT NULL DEFAULT '0',
  `hash_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `has_contact_information` int NOT NULL DEFAULT '0',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_message_id` int NOT NULL DEFAULT '0',
  `notification_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_chat_messages`
--
ALTER TABLE `uni_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `whom_user_id` (`whom_user_id`),
  ADD KEY `dialogue_id` (`dialogue_id`),
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `delete_status` (`delete_status`),
  ADD KEY `channel_id` (`channel_id`),
  ADD KEY `has_contact_information` (`has_contact_information`),
  ADD KEY `status` (`status`),
  ADD KEY `parent_message_id` (`parent_message_id`),
  ADD KEY `notification_status` (`notification_status`),
  ADD KEY `responder_id` (`responder_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_chat_messages`
--
ALTER TABLE `uni_chat_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
