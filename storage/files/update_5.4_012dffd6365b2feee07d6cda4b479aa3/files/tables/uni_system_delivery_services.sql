
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_delivery_services` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `params` mediumtext COLLATE utf8mb4_general_ci,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `available_price_min` float NOT NULL DEFAULT '0',
  `available_price_max` float NOT NULL DEFAULT '0',
  `min_weight` float NOT NULL DEFAULT '0',
  `max_weight` float NOT NULL DEFAULT '0',
  `required_price_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_delivery_services`
--

INSERT INTO `uni_system_delivery_services` (`id`, `name`, `params`, `alias`, `status`, `image`, `available_price_min`, `available_price_max`, `min_weight`, `max_weight`, `required_price_order`) VALUES
(1, 'Яндекс.Доставка', NULL, 'yandex', 1, NULL, 10, 100000, 0, 15000, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_delivery_services`
--
ALTER TABLE `uni_system_delivery_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_delivery_services`
--
ALTER TABLE `uni_system_delivery_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
