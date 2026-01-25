
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_system_payment_services` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `url_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secure_deal_available` int NOT NULL DEFAULT '0',
  `secure_deal_min_amount` float NOT NULL DEFAULT '0',
  `secure_deal_max_amount` float NOT NULL DEFAULT '0',
  `type_score` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_score_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secure_deal_status` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secure_description` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_payment_services`
--

INSERT INTO `uni_system_payment_services` (`id`, `name`, `alias`, `sorting`, `params`, `url_link`, `status`, `title`, `secure_deal_available`, `secure_deal_min_amount`, `secure_deal_max_amount`, `type_score`, `type_score_name`, `secure_deal_status`, `image`, `secure_description`) VALUES
(1, 'ЮКасса', 'yookassa', 0, '', '', 0, 'T-Банк, Сбер, СБП', 0, 1, 350000, 'score_card', 'Мир', 0, NULL, NULL),
(4, 'Т-Банк', 'tbank', 0, '', '', 0, '', 0, 1, 350000, 'score_card', 'Мир', 0, NULL, NULL),
(5, 'LiqPay', 'liqpay', 0, '', '', 0, '', 1, 1, 350000, 'score_card', 'Visa, MasterCard', 1, NULL, NULL),
(6, 'ЮМани', 'yoomoney', 0, '', '', 0, 'T-Банк, Сбер, СБП', 1, 1, 100000, 'score_wallet', 'Номер кошелька', 1, NULL, 'Зарегистрируйтесь на сайте yoomoney.ru и укажите номер кошелька'),
(7, 'Stripe', 'stripe', 0, '', '', 0, 'Visa, MasterCard', 1, 1, 100000, 'score_card', 'Visa, MasterCard', 1, NULL, NULL),
(8, 'RoboKassa', 'robokassa', 0, '', '', 0, 'Мир', 0, 0, 0, 'score_card', NULL, 0, NULL, NULL),
(9, 'Bepaid', 'bepaid', 0, '', '', 0, 'Visa,Mastercard,Белкарт', 0, 0, 0, '', NULL, 0, NULL, NULL),
(10, 'Click.uz', 'clickuz', 0, '', '', 0, 'Visa,Mastercard', 0, 0, 0, '', NULL, 0, NULL, NULL),
(11, 'Paypal', 'paypal', 0, '', '', 0, 'Visa,Mastercard', 0, 0, 0, '', NULL, 0, NULL, NULL),
(12, 'FreedomPay', 'freedompay', 0, '', '', 0, 'Visa,Mastercard', 0, 0, 0, '', NULL, 0, NULL, NULL),
(13, 'Unitpay', 'unitpay', 0, '', '', 0, 'Мир', 1, 1, 100000, 'score_card', 'Мир', 1, NULL, 'Укажите номер карты Мир');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_payment_services`
--
ALTER TABLE `uni_system_payment_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_payment_services`
--
ALTER TABLE `uni_system_payment_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
