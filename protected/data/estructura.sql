-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net

-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2012 a las 11:17:55
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7
-- Base de datos: `juego`

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- -------------------
-- VALORES BOOLEANOS
-- -------------------
-- 0 false
-- 1 true
-- -------------------


-- --------------------------------------------------------
-- ---------- DEFINICION DE LAS TABLAS --------------------
-- --------------------------------------------------------

-- --------------------------------------------------------
-- ELIMINACION DE FOREIGN KEYS
-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0; 

-- --------------------------------------------------------

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
  `completada` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_accion_grupal`),
  KEY `acciones_grupales_FKIndex1` (`equipos_id_equipo`),
  KEY `acciones_grupales_FKIndex3` (`habilidades_id_habilidad`),
  KEY `acciones_grupales_FKIndex2` (`usuarios_id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `acciones_individuales`;
CREATE TABLE IF NOT EXISTS `acciones_individuales` (
  `id_accion_individual` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `cooldown` int(11) unsigned NOT NULL,
  KEY `acciones_individuales_FKIndex1` (`usuarios_id_usuario`),
  KEY `acciones_individuales_FKIndex2` (`habilidades_id_habilidad`),  
  PRIMARY KEY (`id_accion_individual`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `acciones_turno`;
CREATE TABLE IF NOT EXISTS `acciones_turno` (
  `partidos_id_partido` int(10) unsigned NOT NULL,
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  KEY `acciones_turno_FKIndex1` (`partidos_id_partido`),
  KEY `acciones_turno_FKIndex2` (`equipos_id_equipo`),  
  KEY `acciones_turno_FKIndex3` (`usuarios_id_usuario`),  
  PRIMARY KEY (`partidos_id_partido`,`equipos_id_equipo`,`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `clasificacion`;
CREATE TABLE IF NOT EXISTS `clasificacion` (
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `posicion` int(10) unsigned NOT NULL,
  `puntos` int(10) unsigned NOT NULL,
  `ganados` int(10) unsigned NOT NULL,
  `empatados` int(10) unsigned NOT NULL,
  `perdidos` int(10) unsigned NOT NULL,
  `diferencia_goles` int(10) NOT NULL,
  PRIMARY KEY (`equipos_id_equipo`),
  KEY `Clasificacion_FKIndex1` (`equipos_id_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `desbloqueadas`;
CREATE TABLE IF NOT EXISTS `desbloqueadas` (
  `habilidades_id_habilidad` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  KEY `desbloqueadas_FKIndex1` (`usuarios_id_usuario`),
  KEY `desbloqueadas_FKIndex2` (`habilidades_id_habilidad`),  
  PRIMARY KEY (`habilidades_id_habilidad`,`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `equipos`;
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partidos_id_partido` int(10) unsigned,
  `nombre` varchar(45) NOT NULL,
  `categoria` int(10) unsigned NOT NULL,
  `aforo_max` int(10) unsigned NOT NULL,
  `aforo_base` int(10) unsigned NOT NULL,
  `nivel_equipo` smallint(5) unsigned NOT NULL,
  `factor_ofensivo` int(10) unsigned NOT NULL,
  `factor_defensivo` int(10) unsigned NOT NULL,
  KEY `equipos_FKIndex1` (`partidos_id_partido`),
  PRIMARY KEY (`id_equipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `habilidades`;
CREATE TABLE IF NOT EXISTS `habilidades` (
  `id_habilidad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `tipo` int(10) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `dinero` int(11) unsigned NOT NULL,
  `animo` int(10) unsigned NOT NULL,
  `influencias` int(10) unsigned NOT NULL,
  `dinero_max` int(10),
  `animo_max` int(10),
  `influencias_max` int(10),
  `participantes_max` int(10) unsigned NOT NULL,
  `cooldown_fin` int(10),
  PRIMARY KEY (`id_habilidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `participaciones`;
CREATE TABLE IF NOT EXISTS `participaciones` (
  `acciones_grupales_id_accion_grupal` int(10) unsigned NOT NULL,
  `usuarios_id_usuario` int(10) unsigned NOT NULL,
  `dinero_aportado` int(10) unsigned NOT NULL,
  `influencias_aportadas` int(10) unsigned NOT NULL,
  `animo_aportado` int(10) unsigned NOT NULL,
  KEY `participantes_FKIndex1` (`usuarios_id_usuario`),
  KEY `participaciones_FKIndex2` (`acciones_grupales_id_accion_grupal`),
  PRIMARY KEY (`acciones_grupales_id_accion_grupal`,`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `partidos`;
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equipos_id_equipo_1` int(10) unsigned NOT NULL,
  `equipos_id_equipo_2` int(10) unsigned NOT NULL,
  `hora` int(11) unsigned NOT NULL,
  `cronica` text NOT NULL,
  `ambiente` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_local` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_visitante` int(10) unsigned NOT NULL DEFAULT '0',
  `dif_niveles` int(10) unsigned NOT NULL DEFAULT '0',
  `aforo_local` int(10) unsigned NOT NULL DEFAULT '0',
  `aforo_visitante` int(10) unsigned NOT NULL DEFAULT '0',
  `turno` int(11) NOT NULL DEFAULT '0',
  `goles_local` int(11) NOT NULL DEFAULT '0',
  `goles_visitante` int(11) NOT NULL DEFAULT '0',
  `moral_local` int(11) NOT NULL DEFAULT '0',
  `moral_visitante` int(11) NOT NULL DEFAULT '0',
  `ofensivo_local` int(11) NOT NULL DEFAULT '0',
  `ofensivo_visitante` int(11) NOT NULL DEFAULT '0',
  `defensivo_local` int(11) NOT NULL DEFAULT '0',
  `defensivo_visitante` int(11) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_partido`),
  KEY `partidos_FKIndex1` (`equipos_id_equipo_1`),
  KEY `partidos_FKIndex2` (`equipos_id_equipo_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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
  `bonus_dinero` int(10) unsigned NOT NULL DEFAULT 0,
  `bonus_influencias` int(10) unsigned NOT NULL DEFAULT 0,
  `bonus_animo` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`usuarios_id_usuario`),
  KEY `recursos_FKIndex1` (`usuarios_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equipos_id_equipo` int(10) unsigned NOT NULL,
  `nick` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `personaje` tinyint(4) unsigned DEFAULT NULL,
  `nivel` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_FKIndex1` (`equipos_id_equipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
-- DECLARACIÓN DE LAS FOREIGN KEY
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE acciones_grupales ADD FOREIGN KEY (equipos_id_equipo) REFERENCES equipos(id_equipo);
ALTER TABLE acciones_grupales ADD FOREIGN KEY (habilidades_id_habilidad) REFERENCES habilidades(id_habilidad);
ALTER TABLE acciones_grupales ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE acciones_individuales ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE acciones_individuales ADD FOREIGN KEY (habilidades_id_habilidad) REFERENCES habilidades(id_habilidad);
ALTER TABLE clasificacion ADD FOREIGN KEY (equipos_id_equipo) REFERENCES equipos(id_equipo);
ALTER TABLE desbloqueadas ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE desbloqueadas ADD FOREIGN KEY (habilidades_id_habilidad) REFERENCES habilidades(id_habilidad);
ALTER TABLE equipos ADD FOREIGN KEY (partidos_id_partido) REFERENCES partidos(id_partido);
ALTER TABLE participaciones ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE participaciones ADD FOREIGN KEY (acciones_grupales_id_accion_grupal) REFERENCES acciones_grupales(id_accion_grupal);
ALTER TABLE partidos ADD FOREIGN KEY (equipos_id_equipo_1) REFERENCES equipos(id_equipo);
ALTER TABLE partidos ADD FOREIGN KEY (equipos_id_equipo_2) REFERENCES equipos(id_equipo);
ALTER TABLE recursos ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE usuarios ADD FOREIGN KEY (equipos_id_equipo) REFERENCES equipos(id_equipo);
ALTER TABLE acciones_turno ADD FOREIGN KEY (partidos_id_partido) REFERENCES partidos(id_partido);
ALTER TABLE acciones_turno ADD FOREIGN KEY (equipos_id_equipo) REFERENCES equipos(id_equipo);
ALTER TABLE acciones_turno ADD FOREIGN KEY (usuarios_id_usuario) REFERENCES usuarios(id_usuario);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
