-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-03-2014 a las 18:17:36
-- Versión del servidor: 5.5.35-cll
-- Versión de PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `municipa_db`
--
CREATE DATABASE IF NOT EXISTS `municipa_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `municipa_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) CHARACTER SET latin1 NOT NULL,
  `url` varchar(120) CHARACTER SET latin1 NOT NULL,
  `email` varchar(95) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `twitter_id` varchar(55) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `email` (`email`,`twitter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor_twitter`
--

DROP TABLE IF EXISTS `autor_twitter`;
CREATE TABLE IF NOT EXISTS `autor_twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `twitter_user` varchar(25) CHARACTER SET latin1 NOT NULL,
  `twitter_name` varchar(90) CHARACTER SET latin1 NOT NULL,
  `last_access` date NOT NULL,
  `token` varchar(120) CHARACTER SET latin1 NOT NULL,
  `token_secret` varchar(120) CHARACTER SET latin1 NOT NULL,
  `followers` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `twitter_id` (`twitter_id`,`twitter_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `muni_id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `descripcion` varchar(90) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `muni_id` (`muni_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2554 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errores`
--

DROP TABLE IF EXISTS `errores`;
CREATE TABLE IF NOT EXISTS `errores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seccion` varchar(80) DEFAULT NULL,
  `usuario` varchar(80) DEFAULT NULL,
  `error` text,
  `fecha` datetime DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_1`
--

DROP TABLE IF EXISTS `link_1`;
CREATE TABLE IF NOT EXISTS `link_1` (
  `id` int(3) DEFAULT NULL,
  `link_1` varchar(6) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `Link_1` (`link_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_2`
--

DROP TABLE IF EXISTS `link_2`;
CREATE TABLE IF NOT EXISTS `link_2` (
  `id` int(4) DEFAULT NULL,
  `link_2` int(3) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `link_2` (`link_2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_refs`
--

DROP TABLE IF EXISTS `link_refs`;
CREATE TABLE IF NOT EXISTS `link_refs` (
  `tabla` varchar(22) NOT NULL,
  `autor_id` int(11) NOT NULL DEFAULT '1',
  `referente_id` int(11) NOT NULL DEFAULT '1',
  `titulo` varchar(130) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(190) NOT NULL,
  `fecha_carga` date NOT NULL,
  UNIQUE KEY `tabla` (`tabla`),
  UNIQUE KEY `titulo` (`titulo`),
  KEY `autor_id` (`autor_id`,`referente_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

DROP TABLE IF EXISTS `municipios`;
CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia_id` int(11) NOT NULL DEFAULT '0',
  `CodMuni` varchar(6) NOT NULL DEFAULT '',
  `CodProv` varchar(3) DEFAULT NULL,
  `municipio` varchar(39) DEFAULT NULL,
  `latitud` float(15,12) NOT NULL DEFAULT '0.000000000000',
  `longitud` float(15,12) NOT NULL DEFAULT '0.000000000000',
  `direccion` varchar(120) NOT NULL DEFAULT '',
  `cp` varchar(15) NOT NULL,
  `web` varchar(62) DEFAULT NULL,
  `carta_organica` varchar(2) DEFAULT NULL,
  `categoria` varchar(33) DEFAULT NULL,
  `fundacion_anio` int(11) NOT NULL DEFAULT '0',
  `fundacion_mes` int(11) NOT NULL DEFAULT '0',
  `fundacion_dia` int(11) NOT NULL DEFAULT '0',
  `fundacion_descripcion` text NOT NULL,
  `jefe_categoria` varchar(31) DEFAULT NULL,
  `jefe` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provincia_id` (`provincia_id`),
  KEY `fundacion_anio` (`fundacion_anio`,`fundacion_mes`,`fundacion_dia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2217 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

DROP TABLE IF EXISTS `provincias`;
CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provincia` (`provincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referente`
--

DROP TABLE IF EXISTS `referente`;
CREATE TABLE IF NOT EXISTS `referente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) CHARACTER SET latin1 NOT NULL,
  `url` varchar(120) CHARACTER SET latin1 NOT NULL,
  `url_stats` varchar(150) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `set_1`
--

DROP TABLE IF EXISTS `set_1`;
CREATE TABLE IF NOT EXISTS `set_1` (
  `link_1` int(4) DEFAULT NULL,
  `poblacion` int(7) DEFAULT NULL,
  `hombres` int(6) DEFAULT NULL,
  `mujeres` int(6) DEFAULT NULL,
  `0_4` int(6) DEFAULT NULL,
  `5_9` int(6) DEFAULT NULL,
  `10_14` int(6) DEFAULT NULL,
  `15_19` int(6) DEFAULT NULL,
  `20_24` int(6) DEFAULT NULL,
  `25_29` int(6) DEFAULT NULL,
  `30_34` int(6) DEFAULT NULL,
  `35_39` int(5) DEFAULT NULL,
  `40_44` int(5) DEFAULT NULL,
  `45_49` int(5) DEFAULT NULL,
  `50_54` int(5) DEFAULT NULL,
  `55_59` int(5) DEFAULT NULL,
  `60_64` int(5) DEFAULT NULL,
  `65_69` int(5) DEFAULT NULL,
  `70_74` int(5) DEFAULT NULL,
  `75_79` int(5) DEFAULT NULL,
  `80_84` int(5) DEFAULT NULL,
  `85_89` int(4) DEFAULT NULL,
  `90_94` int(4) DEFAULT NULL,
  `95_mas` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `set_2`
--

DROP TABLE IF EXISTS `set_2`;
CREATE TABLE IF NOT EXISTS `set_2` (
  `link_1` int(4) DEFAULT NULL,
  `Total Viviendas` int(6) DEFAULT NULL,
  `Casa` int(6) DEFAULT NULL,
  `Rancho` int(4) DEFAULT NULL,
  `Casilla` int(4) DEFAULT NULL,
  `Departamento` int(5) DEFAULT NULL,
  `Inquilinato` int(4) DEFAULT NULL,
  `Pension` int(3) DEFAULT NULL,
  `Local no construido para habitacion` int(3) DEFAULT NULL,
  `Vivienda movil` int(2) DEFAULT NULL,
  `En la calle` int(2) DEFAULT NULL,
  UNIQUE KEY `link_1` (`link_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `telefonos`
--

DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE IF NOT EXISTS `telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `muni_id` int(11) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `descripcion` varchar(90) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `muni_id` (`muni_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5232 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
