-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2024 a las 05:24:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'CAT1 '),
(6, 'cat 2'),
(7, 'CAT 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `thumbnail_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `content`
--

INSERT INTO `content` (`id`, `title`, `description`, `media_url`, `category_id`, `upload_date`, `thumbnail_url`) VALUES
(1, 'peeeeeeeeeeee', 'siu', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 1, '2024-07-17 15:59:49', NULL),
(2, 'PRUEBA N1', 'LO MEJOR', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 5, '2024-07-17 16:35:37', ''),
(3, 'GOD', 'GODD', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 5, '2024-07-17 16:39:55', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(4, 'cole', 'z', 'https://dood.li/d/m8onbwbu1o0a', 5, '2024-07-17 20:26:08', ''),
(5, 'z', 'z', 'https://dood.li/d/m8onbwbu1o0a', 5, '2024-07-17 20:26:47', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(6, '1', '2', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 5, '2024-07-18 00:37:14', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(7, '2', '2', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 5, '2024-07-18 00:37:40', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(8, '3', '3', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 6, '2024-07-18 00:37:53', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(9, '4', '4', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 6, '2024-07-18 00:38:06', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(10, '5', '5', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 7, '2024-07-18 00:38:41', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg'),
(11, '1', '2', 'https://www.youtube.com/watch?v=y2Xhxb4kQhM', 5, '2024-07-18 00:38:54', 'thumbnails/paisaje-luna-vista-desde-planeta_5120x2880_xtrafondos.com.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(2, 'admin', '1234', 1),
(3, 'admin2', '$2y$10$X01kIKkQUqGLRaoFWKQVvevPWCZTTUNGiRz9vo4a5N0fQmgun5Okq', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
