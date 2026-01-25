
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_cron_tasks` (
  `id` int NOT NULL,
  `class_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time_execution` int NOT NULL DEFAULT '0',
  `time_current` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_cron_tasks`
--

INSERT INTO `uni_system_cron_tasks` (`id`, `class_name`, `time_execution`, `time_current`) VALUES
(1, 'importExport', 5, 1),
(2, 'notifications', 1, 1),
(3, 'uniApi', 15, 1),
(4, 'chat', 1, 1),
(5, 'deals', 1, 1),
(6, 'users', 1, 1),
(7, 'ads', 1, 1),
(8, 'tariff', 1, 1),
(9, 'services', 1, 1),
(10, 'tariffNotifications', 60, 1),
(11, 'serviceTop', 15, 1),
(12, 'stories', 1, 1),
(13, 'systemReports', 1, 1),
(14, 'chatNotifications', 10, 1),
(15, 'loadCitiesByUniApi', 3, 1),
(16, 'updateAdsStat', 5, 5),
(17, 'sitemap', 30, 1),
(18, 'runUpdateImportExport', 10, 1),
(19, 'buildFeeds', 60, 1),
(20, 'clearVerifyCodes', 15, 1),
(21, 'clearTempFiles', 60, 1),
(23, 'storiesMakeCollage', 1, 1),
(24, 'deliveryHistory', 5, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_cron_tasks`
--
ALTER TABLE `uni_system_cron_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_cron_tasks`
--
ALTER TABLE `uni_system_cron_tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
