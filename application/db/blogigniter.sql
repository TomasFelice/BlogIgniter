-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-12-2018 a las 09:48:56
-- Versión del servidor: 5.6.20-log
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `blogigniter`
--

create database if not exists blogigniter;

use blogigniter;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url_clean` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `url_clean`) VALUES
(1, 'Categoria 1.1', 'categoria-1'),
(3, 'Categoria 3', 'categoria-3'),
(4, 'Categoria 4', 'categoria-4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url_clean` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(100) NOT NULL,
  `posted` enum('si','no') NOT NULL DEFAULT 'no',
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `url_clean`, `content`, `description`, `created_at`, `image`, `posted`, `category_id`) VALUES
(2, 'Esto es una prueba de un post 2', 'esto-es-una-prueba-de-un-post-2', '<p><img alt="" src="/blogigniter/uploads/post/codeigniter-logo-png-transparent.png" style="height:500px; width:422px" />Esto es una prueba de un post</p>\r\n', '', '2018-12-26 11:43:38', 'esto-es-una-prueba-de-un-post.png', 'si', 3),
(4, 'Lorem Ipsum', 'lorem-ipsum', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', '2018-12-27 11:51:06', 'lorem-ipsum.png', 'si', NULL),
(5, 'Esto es una prueba de un post 2', 'esto-es-una-prueba-de-un-post-2', 'Esto es una prueba de un post', '', '2018-12-27 17:40:41', '', 'si', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`), ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
