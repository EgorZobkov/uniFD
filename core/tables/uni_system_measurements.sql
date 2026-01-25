
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_measurements` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_measurements`
--

INSERT INTO `uni_system_measurements` (`id`, `name`) VALUES
(1, 'tr_546090b4680ec865a9a5a87f7559e03b'),
(2, 'tr_4f4970de53a46f9bcfe7af4821891263'),
(3, 'tr_4a2112d55a2ab957b6c3caa307978a83'),
(4, 'tr_7ac0d3af1cc10ef5d814fc3cef1f3caa'),
(5, 'tr_8a4692354db254b9839b05f187613688');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_measurements`
--
ALTER TABLE `uni_system_measurements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_measurements`
--
ALTER TABLE `uni_system_measurements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
