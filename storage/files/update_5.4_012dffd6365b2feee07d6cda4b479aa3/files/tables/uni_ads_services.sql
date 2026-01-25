
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_ads_services` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `old_price` float NOT NULL DEFAULT '0',
  `count_day` int NOT NULL DEFAULT '1',
  `count_day_fixed` int DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `recommended` int NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `package_status` int NOT NULL DEFAULT '0',
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_ads_services`
--

INSERT INTO `uni_ads_services` (`id`, `name`, `text`, `image`, `price`, `old_price`, `count_day`, `count_day_fixed`, `status`, `recommended`, `position`, `package_status`, `alias`, `sorting`, `name_en`, `text_en`) VALUES
(1, 'Срочно', 'Срочная продажа, у объявления будет метка &quot;Срочно&quot; и оно будет размещено в отдельный блок срочных объявлений', '/storage/images/ff8812d0b2694238b712a2ac9f9d152f.webp', 99, 0, 1, NULL, 1, 0, 0, 0, 'urgently', 0, NULL, NULL),
(2, 'Выделить цветом', 'Выделить цветом объявление, чтобы оно стало еще заметнее', '/storage/images/a986297ad6bfc4990a1c45a0f5efb1ab.webp', 99, 0, 1, 1, 1, 0, 0, 0, 'highlight', 1, NULL, NULL),
(3, 'Поднять в ТОП', 'Ваше объявление будет подниматься в вверх каждый час в каталоге объявлений и на главной странице', '/storage/images/22d151f8f0a55d769587876407783b05.webp', 70, 0, 1, 1, 1, 0, 0, 0, 'top', 3, NULL, NULL),
(4, 'Объявление в сторис', 'Из фотографий вашего объявления будет создан коллаж и он будет добавлен в вашу историю, и опубликован на главной странице и в каталоге', '/storage/images/b8be66ae58b7cb3120e737cac809d048.webp', 149, 0, 1, NULL, 1, 0, 0, 0, 'stories', 2, NULL, NULL),
(6, 'Пакет размещений', '🔥Срочно, Выделить цветом, Поднять объявление, Объявление в сторис', '/storage/images/c1ef745b55e9e54792298bcb6d3720d0.webp', 249, 549, 3, 1, 1, 1, 0, 1, 'package', 4, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_ads_services`
--
ALTER TABLE `uni_ads_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_ads_services`
--
ALTER TABLE `uni_ads_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
