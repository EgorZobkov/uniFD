
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `uni_system_settings_search_snippets` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_system_settings_search_snippets`
--

INSERT INTO `uni_system_settings_search_snippets` (`id`, `title`, `subtitle`, `route_name`) VALUES
(1, 'SMTP', 'Настройки - Рассылка', 'settings/mailing'),
(2, 'Контакты/О компании', 'Настройки - Информация', 'settings/information'),
(3, 'Шаблоны email писем', 'Настройки - Рассылка', 'settings/mailing'),
(4, 'Логотип', 'Настройки - Графика', 'settings/graphics'),
(5, 'Платежные системы', 'Настройки - Интеграции', 'settings/integrations'),
(6, 'Telegram bot', 'Настройки - Интеграции', 'settings/integrations'),
(7, 'Настройка смс', 'Настройки - Интеграции', 'settings/integrations'),
(8, 'Карты', 'Настройки - Интеграции', 'settings/integrations'),
(9, 'Оповещения/Отчеты', 'Настройки - Оповещения', 'settings/notifications'),
(10, 'Доступ к сайту', 'Настройки - Доступ', 'settings/access'),
(11, 'Seo/Robots/Sitemap', 'Настройки - Seo', 'settings/seo'),
(12, 'Сторисы', 'Настройки - Профиль', 'settings/profile'),
(13, 'Регистрация/Авторизация', 'Настройки - Профиль', 'settings/profile'),
(14, 'Подтверждение номера телефона', 'Настройки - Профиль', 'settings/profile'),
(15, 'Подтверждение email', 'Настройки - Профиль', 'settings/profile'),
(16, 'Сервисы авторизации', 'Настройки - Профиль', 'settings/profile'),
(17, 'Скрипты и виджеты', 'Настройки - Системное', 'settings/systems'),
(18, 'Валюта/Фомат цены', 'Настройки - Системное', 'settings/systems');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_system_settings_search_snippets`
--
ALTER TABLE `uni_system_settings_search_snippets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_system_settings_search_snippets`
--
ALTER TABLE `uni_system_settings_search_snippets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
