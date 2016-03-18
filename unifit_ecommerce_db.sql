-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2016 a las 04:06:10
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `unifit_ecommerce_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion_breve` varbinary(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `precio` double NOT NULL,
  `talle` varchar(20) NOT NULL,
  `adaptable` tinyint(1) NOT NULL,
  `colores_url` varchar(100) NOT NULL,
  `packs` varchar(20) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `nuevo` tinyint(1) NOT NULL,
  `agotado` tinyint(1) NOT NULL,
  `oferta` tinyint(1) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `precio_oferta` double NOT NULL,
  `precio_surtido` int(11) NOT NULL,
  `precio_oferta_surtido` int(11) NOT NULL,
  `imagenes_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nombre` (`nombre`,`codigo`),
  KEY `categoria_id` (`categoria_id`),
  KEY `oferta` (`oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_pedido`
--

CREATE TABLE IF NOT EXISTS `articulo_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `talle` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `precio_actual` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`,`articulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion_breve` tinytext NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_url` varchar(100) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo_2` (`titulo`),
  KEY `titulo` (`titulo`,`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(255) NOT NULL,
  `dominio` char(255) NOT NULL,
  `direccion` char(255) NOT NULL,
  `telefono` char(255) NOT NULL,
  `admin-email` mediumtext NOT NULL,
  `vendedor-email` mediumtext NOT NULL,
  `contacto-online-email` mediumtext NOT NULL,
  `contacto-email` mediumtext NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `notificaciones` mediumtext NOT NULL,
  `colores` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` double NOT NULL,
  `estado` int(11) NOT NULL,
  `retira` tinyint(1) NOT NULL,
  `compra_en_local` tinyint(1) NOT NULL,
  `direccion_de_entrega` varchar(100) NOT NULL,
  `agencia_de_envio` varchar(100) NOT NULL,
  `forma_de_pago` varchar(100) NOT NULL,
  `lugar` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion`
--

CREATE TABLE IF NOT EXISTS `suscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `email` char(255) NOT NULL,
  `noticias` tinyint(1) NOT NULL,
  `notificaciones` tinyint(1) NOT NULL,
  `catalogos` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(255) NOT NULL,
  `apellido` char(255) NOT NULL,
  `rut` char(100) NOT NULL,
  `email` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `codigo` char(100) NOT NULL,
  `direccion` char(255) NOT NULL,
  `telefono` char(100) NOT NULL,
  `celular` char(100) NOT NULL,
  `departamento` char(255) NOT NULL,
  `ciudad` char(255) NOT NULL,
  `suscrito` tinyint(1) NOT NULL DEFAULT '0',
  `registrado` tinyint(1) NOT NULL DEFAULT '0',
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  KEY `nombre` (`nombre`,`apellido`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
