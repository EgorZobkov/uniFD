
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_users_tariffs_items` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_users_tariffs_items`
--

INSERT INTO `uni_users_tariffs_items` (`id`, `name`, `code`, `text`, `name_en`, `text_en`) VALUES
(1, 'Персональный магазин', 'shop', '', NULL, NULL),
(2, 'Дополнительные страницы в магазине', 'shop_page', '', NULL, NULL),
(3, 'Уникальный адрес магазина', 'unique_shop_address', '', NULL, NULL),
(5, 'Скрытие конкурентов в ваших объявлениях', 'hiding_competitors_ads', '', NULL, NULL),
(6, 'Расширенная аналитика', 'extra_statistics', '', NULL, NULL),
(7, 'Сторисы на 3 дня', 'stories_3_days', 'Обычные сторисы удаляются через 24 часа, а ваши будут активны 3 дня', NULL, NULL),
(8, 'Сторисы на 7 дня', 'stories_7_days', 'Обычные сторисы удаляются через 24 часа, а ваши будут активны 7 дней', NULL, NULL),
(9, 'Публикация фото и видео в сторис', 'add_stories', '', NULL, NULL),
(10, 'Автопродление объявлений', 'autorenewal', '', NULL, NULL),
(11, 'Размещение партнерских товаров', 'partner_products', '', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_users_tariffs_items`
--
ALTER TABLE `uni_users_tariffs_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_users_tariffs_items`
--
ALTER TABLE `uni_users_tariffs_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
