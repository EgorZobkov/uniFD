
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_transactions_deals` (
  `id` int NOT NULL,
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `status_payment` int NOT NULL DEFAULT '0',
  `status_processing` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time_create` timestamp NULL DEFAULT NULL,
  `status_completed` int NOT NULL DEFAULT '0',
  `from_user_id` int NOT NULL DEFAULT '0',
  `whom_user_id` int NOT NULL DEFAULT '0',
  `delivery_service_id` int NOT NULL DEFAULT '0',
  `time_update` timestamp NULL DEFAULT NULL,
  `operation_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time_completed` timestamp NULL DEFAULT NULL,
  `delivery_answer_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `delivery_data` text COLLATE utf8mb4_general_ci,
  `delivery_amount` float NOT NULL DEFAULT '0',
  `delivery_history_data` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_transactions_deals`
--
ALTER TABLE `uni_transactions_deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `whom_user_id` (`whom_user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `status_processing` (`status_processing`),
  ADD KEY `status_completed` (`status_completed`),
  ADD KEY `delivery_service_id` (`delivery_service_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_transactions_deals`
--
ALTER TABLE `uni_transactions_deals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
