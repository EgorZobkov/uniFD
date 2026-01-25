
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_frontend_home_widgets` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `sorting` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_frontend_home_widgets`
--

INSERT INTO `uni_frontend_home_widgets` (`id`, `name`, `code`, `status`, `sorting`) VALUES
(1, 'tr_f76dc02fcf00fa940d32ea4c2c495ac0', 'slider_categories', 1, 2),
(2, 'tr_5d5c4c3b46ab3709922e4282aa2cf1a8', 'stories', 1, 3),
(3, 'tr_b5edb7f85cdf702189af31b1f498eca2', 'shops', 1, 4),
(4, 'tr_29256020903b85f5d366a80d429695c6', 'promo_banners', 1, 1),
(5, 'tr_2dcd9bcb6d36c50d1e86379711dcfd3a', 'articles_blog', 1, 7),
(6, 'tr_ed4e713acc48f971eb2438c25f94d90d', 'ads_categories', 0, 6),
(7, 'tr_ae3626f07deee88cda75b6a1d55dc326', 'vip_ads', 1, 5),
(10, 'tr_73b61b300400a518b90c24c87a43fdff', 'ads', 1, 8);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_frontend_home_widgets`
--
ALTER TABLE `uni_frontend_home_widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_frontend_home_widgets`
--
ALTER TABLE `uni_frontend_home_widgets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
