
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_reviews` (
  `id` int NOT NULL,
  `item_id` int NOT NULL DEFAULT '0',
  `from_user_id` int NOT NULL DEFAULT '0',
  `whom_user_id` int NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `rating` int NOT NULL DEFAULT '0',
  `media` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `time_create` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `parent_id` int NOT NULL DEFAULT '0',
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_reviews`
--
ALTER TABLE `uni_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `who_user_id` (`whom_user_id`),
  ADD KEY `rating` (`rating`),
  ADD KEY `status` (`status`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_reviews`
--
ALTER TABLE `uni_reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
