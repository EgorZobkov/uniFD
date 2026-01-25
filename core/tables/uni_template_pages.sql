
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `uni_template_pages` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `template_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `freeze` int NOT NULL DEFAULT '0',
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `seo` int NOT NULL DEFAULT '1',
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edit_status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uni_template_pages`
--

INSERT INTO `uni_template_pages` (`id`, `name`, `template_name`, `freeze`, `alias`, `status`, `seo`, `route_name`, `edit_status`) VALUES
(1, 'tr_97b7df708cfeca27679873b624d0b8da', 'home', 1, NULL, 1, 1, 'home', 0),
(2, 'tr_67c870150a4c708caeb201257e7f199e', 'catalog', 1, NULL, 1, 1, 'catalog', 0),
(4, 'tr_80b530868d4e2382bf27da366aaf2b46', 'header', 1, NULL, 1, 0, NULL, 0),
(5, 'tr_cba1444c768ce380a18d0227dbc43b2c', 'footer', 1, NULL, 1, 0, NULL, 0),
(29, 'tr_59b81ec8ee6a8cd874c6d3c8f750ebe0', 'profile', 1, NULL, 1, 1, 'profile', 0),
(30, 'tr_c3e0b7577d733f3840cef4d79ec33944', 'ad-create', 1, NULL, 1, 1, 'ad-create', 0),
(32, 'tr_daaa944db7ed5f5aab787a57e202b26e', 'ad-card', 1, NULL, 1, 1, 'ad-card', 0),
(33, 'tr_87c3c73065ae286cbdecf927352495e6', 'ad-paid-services', 1, NULL, 1, 1, 'ad-services', 0),
(34, 'tr_0c1b9a1f4d4bc302fd59aa2fb46afeff', 'ad-publication-success', 1, NULL, 1, 1, 'ad-publication-success', 0),
(36, 'tr_990d85626f7b4f3af16e21219eeabc90', 'user-card', 1, NULL, 1, 1, 'user-card', 0),
(37, 'tr_a786630e4e6381008cb66af84b6d766b', 'user-card-ads', 1, NULL, 1, 1, 'user-card-ads', 0),
(39, 'tr_df7a76108066002ede93f4b1b5cc9111', 'cart', 1, 'cart', 1, 1, 'cart', 0),
(40, 'tr_445121d6d202d8729e2e0712869f9289', 'cart-checkout', 1, NULL, 1, 1, 'cart-checkout', 0),
(41, 'tr_6da11dabeb345f1c2a1228cc7f2eb3c1', 'shop', 1, NULL, 1, 1, 'shop', 0),
(42, 'tr_99999f679a680850a14e6ffd562c6636', 'shops', 1, NULL, 1, 1, 'shops', 0),
(43, 'tr_801e26220f10da15576ebf37d73138bc', 'shop-catalog', 1, NULL, 1, 1, 'shop-catalog', 0),
(44, 'tr_658042657d0561ce1d1adf5476b191a9', 'auth', 1, 'auth', 1, 1, 'login', 0),
(45, 'tr_efe234f05e3d8e2e461c74e15cc38a2a', 'blog', 1, 'blog', 1, 1, 'blog', 0),
(46, 'tr_2c111cd55c678777d51484fbb6d4d6fb', 'blog-post', 1, '', 1, 1, 'blog-post', 0),
(47, 'tr_dd4c5bce5f0be974d8458b5143afa94a', 'ff2f91623c2e4bd259f2309aea406ec5', 0, 'rules', 1, 1, NULL, 1),
(48, 'tr_9bb3d9965a5fc99fd89d76b3d49b0c82', '9b0e72c8bed2f7d6b8b49de3f1649e29', 0, 'privacy-policy', 1, 1, NULL, 1),
(50, 'tr_b79a467680b4a5e07288b41d67688e97', 'map', 1, '', 1, 1, 'search-by-map', 0),
(52, 'tr_9cf8fa5c36c74aa9cc9ff8847098390b', 'ccf9bd1dde54409141003ba98b91d162', 0, 'about', 1, 1, NULL, 1),
(53, 'tr_1c4b6f219f06cc8b57795cdf9be6d89d', '561e92f386c8398e7735fdce51ff3c4b', 0, 'support', 1, 1, NULL, 1),
(55, 'tr_9b2de77271c95f165870bceacd58f8c6', '4e670372ca6dbaad4b954d53a67cc47c', 0, 'business-tariffs', 1, 1, NULL, 1),
(56, 'tr_e2495f0f9a7e5a3441612d5ba426dbe4', '14ca38153a6e8066420b5d86e29ba690', 0, 'secure-deals', 1, 1, NULL, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `uni_template_pages`
--
ALTER TABLE `uni_template_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `uni_template_pages`
--
ALTER TABLE `uni_template_pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
