
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_ads_data` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `media` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` int NOT NULL DEFAULT '0',
  `article_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `currency_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `old_price` float NOT NULL DEFAULT '0',
  `price_measure_id` int DEFAULT '0',
  `in_stock` int NOT NULL DEFAULT '1',
  `not_limited` int NOT NULL DEFAULT '0',
  `publication_period` int NOT NULL DEFAULT '30',
  `contact_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contacts` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `link_video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category_id` int NOT NULL DEFAULT '0',
  `city_id` int NOT NULL DEFAULT '0',
  `geo_latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `geo_longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `region_id` int NOT NULL DEFAULT '0',
  `country_id` int NOT NULL DEFAULT '0',
  `search_tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reason_blocking_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time_create` timestamp NULL DEFAULT NULL,
  `time_update` timestamp NULL DEFAULT NULL,
  `time_expiration` timestamp NULL DEFAULT NULL,
  `import_id` int NOT NULL DEFAULT '0',
  `price_gratis_status` int NOT NULL DEFAULT '0',
  `price_fixed_status` int NOT NULL DEFAULT '0',
  `online_view_status` int NOT NULL DEFAULT '0',
  `condition_new_status` int NOT NULL DEFAULT '0',
  `condition_brand_status` int NOT NULL DEFAULT '0',
  `block_forever_status` int NOT NULL DEFAULT '0',
  `external_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `booking_status` int NOT NULL DEFAULT '0',
  `auto_renewal_status` int NOT NULL DEFAULT '0',
  `service_urgently_status` int NOT NULL DEFAULT '0',
  `service_highlight_status` int NOT NULL DEFAULT '0',
  `service_top_status` int NOT NULL DEFAULT '0',
  `time_sorting` timestamp NULL DEFAULT NULL,
  `count_display` int NOT NULL DEFAULT '0',
  `partner_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `import_item_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `delivery_status` int NOT NULL DEFAULT '0',
  `total_rating` float NOT NULL DEFAULT '0',
  `total_reviews` int NOT NULL DEFAULT '0',
  `partner_button_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `partner_button_color` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_ads_data`
--
ALTER TABLE `uni_ads_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `time_create` (`time_create`),
  ADD KEY `import_id` (`import_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `price_gratis_status` (`price_gratis_status`),
  ADD KEY `price_fixed_status` (`price_fixed_status`),
  ADD KEY `online_view_status` (`online_view_status`),
  ADD KEY `condition_new_status` (`condition_new_status`),
  ADD KEY `condition_brand_status` (`condition_brand_status`),
  ADD KEY `article` (`article_number`),
  ADD KEY `title` (`title`),
  ADD KEY `price` (`price`),
  ADD KEY `alias` (`alias`),
  ADD KEY `service_urgently_status` (`service_urgently_status`),
  ADD KEY `service_highlight_status` (`service_highlight_status`),
  ADD KEY `time_sorting` (`time_sorting`),
  ADD KEY `count_display` (`count_display`),
  ADD KEY `import_item_id` (`import_item_id`),
  ADD KEY `delivery_status` (`delivery_status`),
  ADD KEY `total_rating` (`total_rating`),
  ADD KEY `total_reviews` (`total_reviews`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_ads_data`
--
ALTER TABLE `uni_ads_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
