
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_system_home_widgets` (
  `id` int NOT NULL,
  `template_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `size_cell` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_home_widgets`
--

INSERT INTO `uni_system_home_widgets` (`id`, `template_name`, `name`, `size_cell`, `sorting`) VALUES
(1, 'users-online', 'tr_479138043e12d774d31f260ec540d124', 'col-xl-4 col-md-4 col-12', 4),
(7, 'transactions-by-week', 'tr_37595dfe01895fc40df76d1647bfe726', 'col-xl-6 col-md-6 col-12', 7),
(8, 'count-users-by-week', 'tr_8ca15f0c0a20316ec15ef8636c3debeb', 'col-xl-6 col-md-6 col-12', 6),
(9, 'auth-uniid', 'tr_adf79fb537d09f056e326c0c44faa3c3', 'col-xl-6 col-md-6 col-12', 1),
(10, 'traffic-realtime', 'tr_85c2944cf3f8ba95f9703da7688ead36', 'col-xl-4 col-md-4 col-12', 3),
(11, 'notifications', 'tr_ae85b47491301ecd7d3d6a5b16590c18', 'col-xl-6 col-md-6 col-12', 2),
(12, 'monthly-summary', 'tr_fbdae16c64a1fa6ef335660214e391ef', 'col-xl-12 col-md-12 col-12', 0),
(13, 'waiting-action', 'tr_b27dbd3219dd9864d1c0a3bba526c272', 'col-xl-4 col-md-4 col-12', 5),
(14, 'statistics-mobile-app', 'tr_fe2b66be80f0dc1e85734c8e210e9406', 'col-xl-6 col-md-6 col-12', 7);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_home_widgets`
--
ALTER TABLE `uni_system_home_widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_home_widgets`
--
ALTER TABLE `uni_system_home_widgets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
