
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_privileges` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `permissions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `route_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_privileges`
--

INSERT INTO `uni_system_privileges` (`id`, `name`, `group_id`, `permissions`, `route_id`) VALUES
(2, 'tr_34a370665a8e783220935f5457f18c23', 'users', 'view,control', 'dashboard-users'),
(3, 'tr_6820073e8f19467234fc8db64aef7742', 'settings', 'view,control', 'dashboard-settings'),
(5, 'tr_eac53a1db7e70df6bd847ccc1bfebaf9', 'templates', 'view,control', 'dashboard-templates'),
(7, 'tr_36b9d282866d29a59f53e6228f3f5e25', 'transactions', 'view,control', 'dashboard-transactions'),
(8, 'tr_19c538cb7fdaaa730b54ae0a924493ce', 'countries', 'view,control', 'dashboard-countries'),
(9, 'tr_d6c8b0babc6b5631f5909107df53c535', 'settings', 'view,control', 'dashboard-seo'),
(10, 'tr_e55b08cb0a47a9c457dafa3ea3cad149', 'ads-services', 'view,control', 'dashboard-ads-services'),
(11, 'tr_626cab09078cf912621ab5c0d85d2f64', 'ads', 'view,control', 'dashboard-ads'),
(12, 'tr_d9773ec4faf196c72660f29829d11673', 'ads-categories', 'view,control', 'dashboard-ads-categories'),
(13, 'tr_8880968588a4db91eb4f2c76c6af9368', 'chat', 'view,control', 'dashboard-chat'),
(14, 'tr_27fe73dea79edcbebd416bb0152588ee', 'deals', 'view,control', 'dashboard-deals'),
(15, 'tr_61299a4d833397ccd1ad75f7b2ac2379', 'reviews', 'view,control', 'dashboard-reviews'),
(16, 'tr_c53d8f00f376baa9efb380759e226ba0', 'verifications', 'view,control', 'dashboard-users-verifications'),
(17, 'tr_6fa9b2e93e1156dfd7dbeb2515f94bd9', 'shops', 'view,control', 'dashboard-shops'),
(18, 'tr_d44adce8d76935c7ce142ff8e2ff6307', 'stories', 'view,control', 'dashboard-stories'),
(19, 'tr_d540976c787a4c9102faeb996e5c9dae', 'blog', 'view,control', 'dashboard-blog-posts'),
(20, 'tr_420dc5580b9a15ca10ba0802ccebe6a4', 'blog', 'view,control', 'dashboard-blog-categories'),
(21, 'tr_f374692751e90d2d1c1009a560686f38', 'filters', 'view,control', 'dashboard-ads-filters'),
(22, 'tr_385955be4aad70809c97857902607912', 'complaints', 'view,control', 'dashboard-complaints'),
(25, 'tr_312c1b8baffb53a7aa3237b1f8eac920', 'services', 'view,control', 'dashboard-services'),
(26, 'tr_fc92f3ae3e62d05842fca60e3f2d010e', 'settings', 'view,control', 'dashboard-import-export'),
(27, 'tr_82f2e7cf6789f6181edcba50aafb28ec', 'promo-banners', 'view,control', 'dashboard-promo-banners'),
(28, 'tr_bd5cd640756e0b543f3eb5676f487c8c', 'filemanager', 'control', 'dashboard-filemanager'),
(29, 'tr_6f5f332096203d437e2234e65b270a30', 'home', 'view', 'dashboard-home'),
(30, 'tr_e845259970bfe84787077d6f01b0119f', 'translates', 'view,control', 'dashboard-translates'),
(31, 'tr_f4d3054183840abcb6e9c11cef13bf61', 'search-keywords', 'view,control', 'dashboard-search-keywords'),
(32, 'tr_2c509910dde7a273dbe2df2dc77bceff', 'mobile-app', 'view', 'dashboard-mobile-app-stat');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_privileges`
--
ALTER TABLE `uni_system_privileges`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_privileges`
--
ALTER TABLE `uni_system_privileges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
