
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_menu` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `route_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  `submenu` int NOT NULL DEFAULT '0',
  `route_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_menu`
--

INSERT INTO `uni_system_menu` (`id`, `name`, `parent_id`, `icon`, `route_alias`, `sorting`, `submenu`, `route_id`) VALUES
(1, 'tr_a78cac19c49e6f41cb52704ff9001311', 0, '<i class=\"menu-icon tf-icons ti ti-layout-grid\"></i>', 'dashboard', 0, 0, 'dashboard-home'),
(6, 'tr_43cb474b2a0c5bf0aae789d555ab4a78', 0, '<i class=\"menu-icon tf-icons ti ti-messages\"></i>', 'dashboard-chat', 4, 0, 'dashboard-chat'),
(7, 'tr_a8d066963453f3c5ccbf249a4daa00df', 0, '<i class=\"menu-icon ti ti-list-details\"></i>', NULL, 3, 1, NULL),
(8, 'tr_7a7fa51762f9891086ee4b934ae300f7', 7, NULL, 'dashboard-ads', 0, 0, 'dashboard-ads'),
(9, 'tr_91e5da89c9104911e397de09c07e327f', 7, NULL, 'dashboard-ads-categories', 0, 0, 'dashboard-ads-categories'),
(10, 'tr_d75f6e91789c9269ffe8410025d7b29b', 7, NULL, 'dashboard-ads-filters', 0, 0, 'dashboard-ads-filters'),
(11, 'tr_c3234003e2e2091ab2048fdc538c0344', 0, '<i class=\"menu-icon ti ti-brand-cashapp\"></i>', 'dashboard-services', 4, 0, 'dashboard-services'),
(12, 'tr_6555731838e47129020769da74d73e14', 7, NULL, 'dashboard-complaints', 0, 0, 'dashboard-complaints'),
(13, 'tr_ec88a12b17670b3f31538dba3e2fcc61', 7, NULL, 'dashboard-reviews', 0, 0, 'dashboard-reviews'),
(14, 'tr_c4fe50f2b0326a413c1c7d1db669a015', 0, '<i class=\"menu-icon tf-icons ti ti-users\"></i>', NULL, 3, 1, NULL),
(15, 'tr_461c5cb7e8452b9e7f7015dc2ae37ce6', 14, NULL, 'dashboard-users', 0, 0, 'dashboard-users'),
(16, 'tr_0de6bda5aabd48227da2f67e689abf90', 14, NULL, 'dashboard-stories', 0, 0, 'dashboard-stories'),
(18, 'tr_60fa5cbbedf74950c0e1b088f3c02503', 14, NULL, 'dashboard-users-verifications', 0, 0, 'dashboard-users-verifications'),
(19, 'tr_033d2e30e92b17366b6970b193a19a6e', 0, '<i class=\"menu-icon ti ti-article\"></i>', NULL, 8, 1, NULL),
(20, 'tr_84a10e46730239f3246dd1a3d139139a', 0, '<i class=\"menu-icon ti ti-world\"></i>', 'dashboard-countries', 9, 0, 'dashboard-countries'),
(23, 'tr_07702b882acbb94f2ff5023bed397c53', 45, NULL, 'dashboard-advertising', 0, 0, 'dashboard-advertising'),
(24, 'tr_f9b196effb3321f39e2f07809f9c6826', 45, NULL, 'dashboard-promo-banners', 0, 0, 'dashboard-promo-banners'),
(26, 'tr_2a86e14acf920021c87290f849d04429', 33, NULL, 'dashboard-seo', 0, 0, 'dashboard-seo'),
(28, 'tr_9ec6638fdd55b4239038339121238df8', 33, NULL, 'dashboard-import-export', 0, 0, 'dashboard-import-export'),
(33, 'tr_4d83922bc8b01ce5cf30f5e458c1b1da', 0, '<i class=\"menu-icon ti ti-settings\"></i>', NULL, 13, 1, NULL),
(36, 'tr_15844eb62d67561a17e1a5820cef5da8', 45, NULL, 'dashboard-templates', 0, 0, 'dashboard-templates'),
(39, 'tr_a9d55e3db1439b322bb12c63f0155689', 33, NULL, 'dashboard-settings', 0, 0, 'dashboard-settings'),
(40, 'tr_09d2f352fdaed61b2270188a82311487', 7, NULL, 'dashboard-shops', 7, 0, 'dashboard-shops'),
(42, 'tr_f2519b1298bd264c139c66fe8edbf5bf', 19, NULL, 'dashboard-blog-posts', 8, 0, 'dashboard-blog-posts'),
(43, 'tr_91e5da89c9104911e397de09c07e327f', 19, NULL, 'dashboard-blog-categories', 8, 0, 'dashboard-blog-categories'),
(45, 'tr_b39f2ccec75760ef442d06387670e5e4', 0, '<i class=\"menu-icon ti ti-tools\"></i>', 'dashboard-decoration-template', 14, 1, NULL),
(46, 'tr_1d3e449ded173a6fcee332113e31138e', 0, '<i class=\"menu-icon ti ti-timeline\"></i>', 'dashboard-transactions', 1, 0, 'dashboard-transactions'),
(47, 'tr_28231bf0d28f3b5cd6230cf557c22773', 0, '<i class=\"menu-icon ti ti-briefcase\"></i>', 'dashboard-deals', 2, 0, 'dashboard-deals'),
(48, 'tr_a411b3f9e26b33cd0115ec7db08e9efd', 33, NULL, 'dashboard-translates', 0, 0, 'dashboard-translates'),
(49, 'tr_7eee47ce4767b343dddd09c06f1f0a2e', 33, NULL, 'dashboard-updates', 0, 0, 'dashboard-updates'),
(50, 'tr_bb5842c58c8ff5145813b45bf4a3a150', 33, NULL, 'dashboard-search-keywords', 0, 0, 'dashboard-search-keywords');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_menu`
--
ALTER TABLE `uni_system_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_menu`
--
ALTER TABLE `uni_system_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
