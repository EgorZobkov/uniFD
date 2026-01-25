
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_system_verification_users_permissions` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_verification_users_permissions`
--

INSERT INTO `uni_system_verification_users_permissions` (`id`, `name`, `code`) VALUES
(1, 'tr_a0548558a5976b92970ed6190f71f8dd', 'view_contacts'),
(2, 'tr_b42b78224a230fd57a3165f5eb7d521b', 'create_ad'),
(4, 'tr_c88fdd1ca9f4aeac7c961d9c5ec19b80', 'create_order'),
(5, 'tr_58217867b9bf4be0a3a3c9d55bca99cb', 'create_review'),
(6, 'tr_dab0795ce1ad8d0b8674a7c6c6772bf9', 'open_shop');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_verification_users_permissions`
--
ALTER TABLE `uni_system_verification_users_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_verification_users_permissions`
--
ALTER TABLE `uni_system_verification_users_permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
