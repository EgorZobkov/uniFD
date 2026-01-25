
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_import_export_feeds` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category_id` int NOT NULL DEFAULT '0',
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `feed_format` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `autoupdate` int NOT NULL DEFAULT '0',
  `count_upload_items` int NOT NULL DEFAULT '0',
  `shop_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_company_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_contact_phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `utm_data` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `out_filters_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_import_export_feeds`
--
ALTER TABLE `uni_import_export_feeds`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_import_export_feeds`
--
ALTER TABLE `uni_import_export_feeds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
