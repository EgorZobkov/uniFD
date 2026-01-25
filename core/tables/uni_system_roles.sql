
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_roles` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `chief` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_roles`
--

INSERT INTO `uni_system_roles` (`id`, `name`, `chief`) VALUES
(1, 'tr_f81f125abfbc5df426b2769a9700ed32', 1),
(2, 'tr_b93a4bab7c512b0cb5a49e8eef7b15a3', 0),
(3, 'tr_30b1a6528971e4fbe76a8b6b36e4a464', 0),
(4, 'tr_338b925d4e7c3df08ab1202a87d6c642', 0),
(5, 'tr_0411438bf9b67e3cab13fa3c708a691c', 0),
(6, 'tr_8c75ccec04dee1a52751432af1f800f5', 0),
(7, 'tr_8540b5bce37e9a8cd90c67eb1195a9ee', 0),
(8, 'tr_e47cef20c85f4c82c53435e7c74d1b7b', 0),
(9, 'tr_7534a815f85523bdb1f26d46ead4b6c3', 0),
(10, 'tr_1acc23940fe5ad8a80b47fb8859c6425', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_roles`
--
ALTER TABLE `uni_system_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_roles`
--
ALTER TABLE `uni_system_roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
