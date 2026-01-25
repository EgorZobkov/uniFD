
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_promo_banners` (
  `id` int NOT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bg_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL DEFAULT '0',
  `page_show` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `geo_link_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_promo_banners`
--

INSERT INTO `uni_promo_banners` (`id`, `sorting`, `image`, `title`, `text`, `link`, `bg_color`, `text_color`, `status`, `category_id`, `page_show`, `title_en`, `text_en`, `geo_link_status`) VALUES
(2, 0, '/storage/images/1a30e9c5d6b52ae524467efbfb08a6d6.webp', 'Видеокурсы', 'Видеокурсы от лучших авторов', '/videokursy', '#34C924', 'white', 1, 0, 'home', NULL, NULL, 0),
(3, 0, '/storage/images/981a06abcc521f70b530ba63bdb50380.webp', 'Скрипты и программное обеспечение', '', '/skripty-i-programmnoe-obespechenie', '#2271B3', 'white', 1, 0, NULL, NULL, NULL, 0),
(4, 0, '/storage/images/ff8812d0b2694238b712a2ac9f9d152f.webp', 'Срочная продажа Авто', 'Самые сочные предложения', '/transport/avtomobili?filter%5Bswitch%5D%5Burgently%5D=1&amp;c_id=5', '#EDFF21', 'black', 1, 0, NULL, NULL, NULL, 0),
(5, 0, '/storage/images/eb70d6d5024b2adadb592a53eff4792e.webp', 'Купить BMW до 3 000 000 руб', '', '/transport/avtomobili?filter%5Bprice_to%5D=3000000&amp;filter%5B90%5D%5B%5D=2798&amp;c_id=5', '#E52B50', 'white', 1, 0, NULL, NULL, NULL, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_promo_banners`
--
ALTER TABLE `uni_promo_banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_promo_banners`
--
ALTER TABLE `uni_promo_banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
