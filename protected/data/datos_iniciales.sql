-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2012 a las 16:00:33
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `juego`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_grupales`
--

DROP TABLE IF EXISTS `acciones_grupales`;
CREATE TABLE IF NOT EXISTS `acciones_grupales` (
  `id_accion_grupal` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `influencias_acc` int(10) unsigned NOT NULL,
  `animo_acc` int(10) unsigned NOT NULL,
  `dinero_acc` int(10) unsigned NOT NULL,
  `jugadores_acc` int(10) unsigned NOT NULL,
  `finalizacion` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_accion_grupal`),
  KEY `acciones_grupales_FKIndex1` (`equipos_id_equipo`),
  KEY `acciones_grupales_FKIndex3` (`habilidades_id_habilidad`),
  KEY `acciones_grupales_FKIndex2` (`usuarios_id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `acciones_grupales`
--

INSERT INTO `acciones_grupales` (`id_accion_grupal`, `usuarios_id_usuario`, `habilidades_id_habilidad`, `equipos_id_equipo`, `influencias_acc`, `animo_acc`, `dinero_acc`, `jugadores_acc`, `finalizacion`) VALUES
(1, 3, 6, 1, 100, 20, 20, 1, 0),
(2, 5, 2, 2, 200, 40, 40, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_individuales`
--

DROP TABLE IF EXISTS `acciones_individuales`;
CREATE TABLE IF NOT EXISTS `acciones_individuales` (
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `cooldown` int(11) unsigned NOT NULL,
  KEY `acciones_individuales_FKIndex1` (`usuarios_id_usuario`),
  KEY `acciones_individuales_FKIndex2` (`habilidades_id_habilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `acciones_individuales`
--

INSERT INTO `acciones_individuales` (`habilidades_id_habilidad`, `usuarios_id_usuario`, `cooldown`) VALUES
(3, 1, 0),
(2, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_turno`
--

DROP TABLE IF EXISTS `acciones_turno`;
CREATE TABLE IF NOT EXISTS `acciones_turno` (
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `partidos_id_partido` int(10) unsigned NOT NULL,
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `turno` smallint(5) unsigned NOT NULL,
  KEY `acciones_turno_FKIndex3` (`equipos_id_equipo`),
  KEY `acciones_turno_FKIndex4` (`partidos_id_partido`),
  KEY `acciones_turno_FKIndex2` (`habilidades_id_habilidad`),
  KEY `acciones_turno_FKIndex1` (`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

DROP TABLE IF EXISTS `clasificacion`;
CREATE TABLE IF NOT EXISTS `clasificacion` (
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `posicion` int(10) unsigned NOT NULL,
  `puntos` int(10) unsigned NOT NULL,
  `ganados` int(10) unsigned NOT NULL,
  `empatados` int(10) unsigned NOT NULL,
  `perdidos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`equipos_id_equipo`),
  KEY `Clasificacion_FKIndex1` (`equipos_id_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`equipos_id_equipo`, `posicion`, `puntos`, `ganados`, `empatados`, `perdidos`) VALUES
(1, 3, 4, 1, 1, 1),
(2, 2, 5, 1, 2, 0),
(3, 1, 7, 2, 1, 0),
(4, 4, 0, 0, 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desbloqueadas`
--

DROP TABLE IF EXISTS `desbloqueadas`;
CREATE TABLE IF NOT EXISTS `desbloqueadas` (
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  KEY `desbloqueadas_FKIndex1` (`usuarios_id_usuario`),
  KEY `desbloqueadas_FKIndex2` (`habilidades_id_habilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `desbloqueadas`
--

INSERT INTO `desbloqueadas` (`habilidades_id_habilidad`, `usuarios_id_usuario`) VALUES
(3, 1),
(4, 1),
(8, 1),
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(7, 2),
(8, 2),
(5, 3),
(6, 3),
(8, 3),
(8, 4),
(1, 5),
(2, 5),
(4, 6),
(5, 7),
(1, 7),
(1, 8),
(2, 8),
(3, 8),
(6, 9),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(5, 10),
(7, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

DROP TABLE IF EXISTS `equipos`;
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `categoria` int(10) unsigned NOT NULL,
  `aforo_max` int(10) unsigned NOT NULL,
  `aforo_base` int(10) unsigned NOT NULL,
  `nivel_equipo` smallint(5) unsigned NOT NULL,
  `factor_ofensivo` int(10) unsigned NOT NULL,
  `factor_defensivo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_equipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nombre`, `categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
(1, 'Rojos', 1, 3000, 400, 12, 7, 6),
(2, 'Verdes', 1, 3000, 500, 10, 7, 6),
(3, 'Negros', 1, 3600, 400, 10, 7, 7),
(4, 'Blancos', 1, 4000, 400, 9, 6, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

DROP TABLE IF EXISTS `habilidades`;
CREATE TABLE IF NOT EXISTS `habilidades` (
  `id_habilidad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_habilidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`id_habilidad`, `codigo`) VALUES
(1, 0),
(2, 1),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participaciones`
--

DROP TABLE IF EXISTS `participaciones`;
CREATE TABLE IF NOT EXISTS `participaciones` (
  `acciones_grupales_id_accion_grupal` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `dinero_aportado` int(10) unsigned NOT NULL,
  `influencias_aportadas` int(10) unsigned NOT NULL,
  `animo_aportado` int(10) unsigned NOT NULL,
  KEY `participantes_FKIndex1` (`usuarios_id_usuario`),
  KEY `participaciones_FKIndex2` (`acciones_grupales_id_accion_grupal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `participaciones`
--

INSERT INTO `participaciones` (`acciones_grupales_id_accion_grupal`, `usuarios_id_usuario`, `dinero_aportado`, `influencias_aportadas`, `animo_aportado`) VALUES
(2, 7, 100, 20, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

DROP TABLE IF EXISTS `partidos`;
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equipos_id_equipo_1` int(10) unsigned NOT NULL,
  `equipos_id_equipo_2` int(10) unsigned NOT NULL,
  `hora` int(11) unsigned NOT NULL,
  `cronica` text NOT NULL,
  PRIMARY KEY (`id_partido`),
  KEY `partidos_FKIndex1` (`equipos_id_equipo_1`),
  KEY `partidos_FKIndex2` (`equipos_id_equipo_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partido`, `equipos_id_equipo_1`, `equipos_id_equipo_2`, `hora`, `cronica`) VALUES
(1, 1, 2, 0, '"par1"'),
(2, 4, 3, 0, '"par2"'),
(3, 3, 1, 0, '"par3"'),
(4, 2, 4, 0, '"par4"'),
(5, 1, 3, 0, '"par5"'),
(6, 4, 2, 0, '"par6"'),
(7, 2, 1, 0, '"par7"'),
(8, 3, 4, 0, '"par8"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

DROP TABLE IF EXISTS `recursos`;
CREATE TABLE IF NOT EXISTS `recursos` (
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `dinero` int(10) unsigned NOT NULL,
  `dinero_gen` float NOT NULL,
  `influencias` int(10) unsigned NOT NULL,
  `influencias_max` int(10) unsigned NOT NULL,
  `influencias_gen` float NOT NULL,
  `animo` int(10) unsigned NOT NULL,
  `animo_max` int(10) unsigned NOT NULL,
  `animo_gen` float NOT NULL,
  KEY `recursos_FKIndex1` (`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`usuarios_id_usuario`, `dinero`, `dinero_gen`, `influencias`, `influencias_max`, `influencias_gen`, `animo`, `animo_max`, `animo_gen`) VALUES
(1, 3000, 7, 8, 10, 1, 230, 300, 6),
(2, 4000, 13, 9, 9, 2, 20, 100, 4),
(3, 1000, 7, 2, 13, 6, 350, 500, 5),
(4, 150, 2, 4, 12, 2, 75, 250, 13),
(5, 1200, 10, 5, 7, 5, 120, 250, 2),
(6, 1000, 10, 0, 15, 5, 12, 150, 7),
(7, 2500, 11, 11, 12, 1, 354, 400, 8),
(8, 500, 4, 10, 10, 2, 14, 100, 10),
(9, 500, 4, 1, 9, 2, 125, 350, 11),
(10, 1200, 6, 10, 10, 1, 180, 200, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `nick` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `personaje` smallint(5) unsigned DEFAULT NULL,
  `nivel` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  KEY `usuarios_FKIndex1` (`equipos_id_equipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `equipos_id_equipo`, `nick`, `pass`, `email`, `personaje`, `nivel`) VALUES
(1, 1, 'xaby', 'xaby', 'xaby@xaby.com', 2, 31),
(2, 2, 'marina', 'marina', 'marina@marina.com', 1, 30),
(3, 1, 'arturo', 'arturo', 'arturo@arturo.com', 2, 14),
(4, 1, 'dani', 'dani', 'dani@dani.com', 0, 20),
(5, 2, 'pedro', 'pedro', 'pedro@pedro.com', 2, 20),
(6, 3, 'manu', 'manu', 'manu@manu.com', 1, 13),
(7, 2, 'rober', 'rober', 'rober@rober.com', 0, 33),
(8, 1, 'marcos', 'marcos', 'marcos@marcos.com', 0, 32),
(9, 2, 'alex', 'alex', 'alex@alex.com', 1, 19),
(10, 3, 'samu', 'samu', 'samu@samu.com', 0, 76);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
