
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_profile_menu` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `sorting` int NOT NULL DEFAULT '0',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `route_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `submenu` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_profile_menu`
--

INSERT INTO `uni_profile_menu` (`id`, `name`, `parent_id`, `sorting`, `icon`, `route_alias`, `submenu`) VALUES
(1, 'tr_7bce5a9f750f4807121e37b94d94a11a', 0, 2, '<i class=\"ti ti-wallet\"></i>', 'profile-wallet', 0),
(2, 'tr_4aacf61c934b464035a6fc2e38162ee3', 0, 3, '<i class=\"ti ti-list-details\"></i>', 'profile-ads', 0),
(3, 'tr_eaa944c8e554433aebd520ba5b5b611c', 0, 4, '<i class=\"ti ti-briefcase\"></i>', NULL, 1),
(4, 'tr_8a8f98081c31dbbda32f5e63385855a3', 3, 0, NULL, 'profile-tariffs', 0),
(5, 'tr_34799fb42f0fa06c88f9ec319676f14d', 3, 0, NULL, 'profile-shop', 0),
(6, 'tr_b89e0559cb94a97ea576c2d717993a8c', 3, 0, NULL, 'profile-statistics', 0),
(7, 'tr_b7f9a00075283b7342436c46ec6d585a', 3, 0, NULL, 'profile-autorenewal', 0),
(10, 'tr_c4d50228f78184ba02f691b38d90992b', 0, 5, '<i class=\"ti ti-truck-delivery\"></i>', 'profile-orders', 0),
(11, 'tr_6b1d189b86eaa16859e9fee1ce931e14', 0, 6, '<i class=\"ti ti-message-circle\"></i>', 'profile-chat', 0),
(16, 'tr_5e5c20907cfc495b23778e03a983ebb7', 0, 7, '<i class=\"ti ti-heart\"></i>', 'profile-favorites', 0),
(19, 'tr_37ab70459413066e1f48b94c38f67053', 0, 8, '<i class=\"ti ti-message\"></i>', 'profile-reviews', 0),
(20, 'tr_bc3500041be69b4e1e837c95995dd325', 0, 1, '<i class=\"ti ti-user\"></i>', 'profile', 0),
(21, 'tr_1cbf79ea1edf243dadfd179ce2322d34', 0, 9, '<i class=\"ti ti-moneybag\"></i>', 'profile-referral', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_profile_menu`
--
ALTER TABLE `uni_profile_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_profile_menu`
--
ALTER TABLE `uni_profile_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
