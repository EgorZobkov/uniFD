
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_users_tariffs` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `old_price` float NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `items_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sorting` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `count_day` int NOT NULL DEFAULT '1',
  `count_day_fixed` int NOT NULL DEFAULT '0',
  `recommended` int NOT NULL DEFAULT '0',
  `onetime` int NOT NULL DEFAULT '0',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_users_tariffs`
--

INSERT INTO `uni_users_tariffs` (`id`, `name`, `price`, `old_price`, `status`, `text`, `items_id`, `sorting`, `image`, `count_day`, `count_day_fixed`, `recommended`, `onetime`, `name_en`, `text_en`) VALUES
(1, 'Максимум', 499, 990, 1, 'Максимальный тариф со всем функционалом', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"8\",\"9\",\"10\"]', 0, NULL, 30, 1, 1, 0, 'Maximum', 'The maximum tariff with all the functionality'),
(2, 'Начальный', 199, 0, 1, 'Базовый тариф с начальным функционалом', '[\"1\",\"3\",\"6\"]', 1, NULL, 30, 1, 0, 0, 'Начальный', 'Базовый тариф с начальным функционалом'),
(3, 'На пробу', 1, 0, 1, 'Протестируйте тариф со всем функционалом в течении дня всего за 1 рубль. Данный тариф можно подключить только 1 раз.', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"9\"]', 2, NULL, 1, 1, 0, 1, 'На пробу', 'Протестируйте тариф со всем функционалом в течении дня всего за 1 рубль. Данный тариф можно подключить только 1 раз.');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_users_tariffs`
--
ALTER TABLE `uni_users_tariffs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_users_tariffs`
--
ALTER TABLE `uni_users_tariffs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
