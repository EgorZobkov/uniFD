
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_system_settings_sections` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `section_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `default_section` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_settings_sections`
--

INSERT INTO `uni_system_settings_sections` (`id`, `name`, `section_id`, `icon`, `sorting`, `route_name`, `default_section`) VALUES
(1, 'tr_0d7361856db7287b2e6a7649dd3f8aa9', 'graphics', 'ti-photo', 2, 'dashboard-settings-graphics', 0),
(2, 'tr_95d792f36e1cbc00ad56c257fa73db5a', 'information', 'ti-info-square-rounded', 1, 'dashboard-settings-information', 1),
(3, 'tr_01394a9f800287396df1ac96562ace55', 'mailing', 'ti-mail', 3, 'dashboard-settings-mailing', 0),
(4, 'tr_fb4eb64137add0fac20794a5f9505c44', 'integrations', 'ti-category-2', 4, 'dashboard-settings-integrations', 0),
(5, 'tr_6fddea8d6605fca94703776823d9bda0', 'systems', 'ti-settings', 8, 'dashboard-settings-systems', 0),
(7, 'tr_ffd57a98dfbb4dd123546d9bffbb5d67', 'access', 'ti-lock', 6, 'dashboard-settings-access', 0),
(8, 'tr_cbda844187e7749d88734a8620fec6b8', 'seo', 'ti-seo', 7, 'dashboard-settings-seo', 0),
(9, 'tr_77d52840cbefac92830a54b6ad4aa0a1', 'profile', 'ti-user-circle', 7, 'dashboard-settings-profile', 0),
(10, 'tr_dcc461ef831568a2866fa409ddf99514', 'market', 'ti-list-details', 7, 'dashboard-settings-market', 0),
(12, 'tr_a3d80526a39e0714d9f8bec1fcb9bdf6', 'home', 'ti-home', 7, 'dashboard-settings-home', 0),
(13, 'tr_26ac08046f115170e2b12fb0163dbd83', 'api-app', 'ti-device-mobile-code', 7, 'dashboard-settings-api-app', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_settings_sections`
--
ALTER TABLE `uni_system_settings_sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_settings_sections`
--
ALTER TABLE `uni_system_settings_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
