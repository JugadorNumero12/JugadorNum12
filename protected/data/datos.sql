-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-12-2012 a las 13:37:32
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

--
-- Volcado de datos para la tabla `acciones_grupales`
--

INSERT INTO `acciones_grupales` (`id_accion_grupal`, `usuarios_id_usuario`, `habilidades_id_habilidad`, `equipos_id_equipo`, `influencias_acc`, `animo_acc`, `dinero_acc`, `jugadores_acc`, `finalizacion`) VALUES
(1, 3, 6, 1, 100, 20, 20, 1, 0),
(2, 5, 2, 2, 200, 40, 40, 2, 0);

--
-- Volcado de datos para la tabla `acciones_individuales`
--

INSERT INTO `acciones_individuales` (`habilidades_id_habilidad`, `usuarios_id_usuario`, `cooldown`) VALUES
(3, 1, 0),
(2, 2, 0);

--
-- Volcado de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`equipos_id_equipo`, `posicion`, `puntos`, `ganados`, `empatados`, `perdidos`) VALUES
(1, 3, 4, 1, 1, 1),
(2, 2, 5, 1, 2, 0),
(3, 1, 7, 2, 1, 0),
(4, 4, 0, 0, 0, 3);

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

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nombre`, `categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
(1, 'Rojos', 1, 3000, 400, 12, 7, 6),
(2, 'Verdes', 1, 3000, 500, 10, 7, 6),
(3, 'Negros', 1, 3600, 400, 10, 7, 7),
(4, 'Blancos', 1, 4000, 400, 9, 6, 8);

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`id_habilidad`, `codigo`, `tipo`, `nombre`, `descripcion`, `dinero`, `animo`, `influencias`, `dinero_max`, `animo_max`, `influencias_max`, `participantes_max`, `cooldown_fin`) VALUES
(1, 'emborracharse', 'individual', 'emborracharse', 'bla bla bla emborracharse', 100, 2, 0, 0, 0, 0, 0, 100),
(2, 'sobornar', 'individual', 'sobornar', 'bla bla bla arbitro', 2000, 1, 100, 0, 0, 0, 0, 300),
(3, 'crear tifo', 'grupal', 'Crear tifo', 'bla bla tifo', 300, 10, 5, 5000, 500, 40, 5, 10000),
(4, 'pelea', 'grupal', 'Pelearse con aficion rival', 'bla bla pum pum', 100, 35, 4, 600, 4000, 75, 7, 8000),
(5, 'hackeo', 'individual', 'hackear pagina web rival', 'bla bla hackers', 300, 1, 10, 0, 0, 0, 0, 350),
(6, 'ola', 'partido', 'Participar en la ola', 'bla bla ueeeee', 0, 5, 0, 0, 0, 0, 0, 0),
(7, 'dinero1', 'pasiva', 'Mas dinero', 'bla bla soy rico', 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'animo1', 'pasiva', 'animo', 'bla bla mas animo', 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Volcado de datos para la tabla `participaciones`
--

INSERT INTO `participaciones` (`acciones_grupales_id_accion_grupal`, `usuarios_id_usuario`, `dinero_aportado`, `influencias_aportadas`, `animo_aportado`) VALUES
(2, 7, 100, 20, 20);

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
