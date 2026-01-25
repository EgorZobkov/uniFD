
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_ads_booking_data` (
  `id` int NOT NULL,
  `deposit_status` int NOT NULL DEFAULT '0',
  `full_payment_status` int NOT NULL DEFAULT '0',
  `deposit_amount` float NOT NULL DEFAULT '0',
  `prepayment_percent` int NOT NULL DEFAULT '0',
  `max_guests` int NOT NULL DEFAULT '0',
  `min_days` int NOT NULL DEFAULT '0',
  `max_days` int NOT NULL DEFAULT '0',
  `week_days_price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `additional_services` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `special_days` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ad_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_ads_booking_data`
--
ALTER TABLE `uni_ads_booking_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_ads_booking_data`
--
ALTER TABLE `uni_ads_booking_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
