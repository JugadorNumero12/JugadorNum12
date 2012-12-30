-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-12-2012 a las 13:37:32
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7
--
-- Base de datos: `juego`
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- ------------------------------------------------------------------------------------
-- Vaciado de tablas
--
-- delete from <<tabla>> where 1
--  borra los n registros almacenados, el siguiente registro que guardemos sera el n+1
-- 
-- truncate <<tabla>>
--  borra los n registros almacenados, el siguiente registro que guardemos sera el 1
-- ------------------------------------------------------------------------------------


TRUNCATE `acciones_grupales`;
INSERT INTO `acciones_grupales` (`id_accion_grupal`, `usuarios_id_usuario`, `habilidades_id_habilidad`, `equipos_id_equipo`, `influencias_acc`, `animo_acc`, `dinero_acc`, `jugadores_acc`, `finalizacion`) VALUES
(1, 3, 6, 1, 100, 20, 20, 1, 0),
(2, 5, 2, 2, 200, 40, 40, 2, 0);

TRUNCATE `acciones_individuales`;
INSERT INTO `acciones_individuales` (`habilidades_id_habilidad`, `usuarios_id_usuario`, `cooldown`) VALUES
(3, 1, 0),
(2, 2, 0);

TRUNCATE `clasificacion`;
INSERT INTO `clasificacion` (`equipos_id_equipo`, `posicion`, `puntos`, `ganados`, `empatados`, `perdidos`) VALUES
 -- ----------------
 -- Rojos   7 puntos
 -- Negros  4 puntos
 -- Verdes  2 puntos
 -- Blancos 2 puntos
 -- ----------------
 (1, 1, 7, 2, 1, 0),
 (2, 3, 2, 0, 2, 1),
 (3, 2, 4, 1, 1, 1),
 (4, 3, 2, 0, 2, 1);

TRUNCATE `desbloqueadas`;
INSERT INTO `desbloqueadas` (`habilidades_id_habilidad`, `usuarios_id_usuario`) VALUES
 -- desbloqueadas de Xaby (empresario)
 (1, 1), (2, 1), (3, 1), (6, 1), (7, 1), (8, 1),
 -- desbloqueadas de marina (movedora)
 (3, 2), (4, 2), (5, 2), (8, 2), (10, 2), (13, 2),
 -- desbloqueadas de arturo (empresario)
 (1, 3), (2, 3), (3, 3), (6, 3), (7, 3), (8, 3),
 -- desbloqueadas de dani (ultra)
 (4, 4), (6, 4), (7, 4), (9, 4), (11, 4), (12, 4), (13, 4),
 -- desbloqueadas de pedro (empresario)
 (1, 5), (2, 5), (3, 5), (6, 5), (7, 5), (8, 5),
 -- desbloqueadas de manu (movedora)
 (3, 6), (4, 6), (5, 6), (8, 6), (10, 6), (13, 6),
 -- desbloqueadas de rober (ultra)
 (4, 7), (6, 7), (7, 7), (9, 7), (11, 7), (12, 7), (13, 7),
 -- desbloqueadas de marcos (ultra)
 (4, 8), (6, 8), (7, 8), (9, 8), (11, 8), (12, 8), (13, 8),
 -- desbloqueadas de alex (movedora)
 (3, 9), (4, 9), (5, 9), (8, 9), (10, 9), (13, 9),
 -- desbloqueadas de samu (ultra)
 (4, 10), (6, 10), (7, 10), (9, 10), (11, 10), (12, 10), (13, 10);

TRUNCATE `equipos`;
INSERT INTO `equipos` (`id_equipo`, `nombre`, `categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
 (1, 'Rojos',   1, 3000, 400, 12, 7, 6),
 (2, 'Verdes',  1, 3000, 500, 10, 7, 6),
 (3, 'Negros',  1, 3600, 400, 10, 7, 7),
 (4, 'Blancos', 1, 4000, 400, 9,  6, 8);

TRUNCATE `habilidades`;
INSERT INTO `habilidades` (`id_habilidad`, `codigo`, `tipo`, `nombre`, `descripcion`, `dinero`, `animo`, `influencias`, `dinero_max`, `animo_max`, `influencias_max`, `participantes_max`, `cooldown_fin`) VALUES
 -- ver tabla_efectos.xml --
 (1,  'FinanciarEvento', 'GRUPAL', 'Financiar un evento promocional', 'El marketing lo es todo: organizar un evento promocional ayudará a caldear el ambiente del próximo partido además de atraer más espectadores al estadio', 100, 2, 0, 0, 0, 0, 0, 100),
 (2,  'IncentivoEconomico', 'GRUPAL', 'Incentivo económico a los jugadores', 'Los jugadores pueden correr más... sólo necesitan un pequeño empujoncito. Aumenta el nivel del equipo para el próximo partido; el impulsor del incentivo recupera influencias que haya destinado a otras acciones', 2000, 1, 100, 0, 0, 0, 0, 300),
 (3,  'OrganizarHomenaje', 'GRUPAL', 'Organizar homenaje a un jugador', 'Organiza un homenaje antes del partido a un jugador amado por la grada y conseguiras atraer a más espectadores para el próximo encuentro; el impulsor gana además influencias dentro del club si logra completar el homenaje', 300, 10, 5, 5000, 500, 40, 5, 10000),
 (4,  'Pintarse', 'GRUPAL', 'Pintarse con los colores del equipo', 'DESCRIPCION PARA PINTARSE', 100, 35, 4, 600, 4000, 75, 7, 8000),
 (5,  'PromoverPartido', 'GRUPAL', 'Promover el partido por las redes sociales', 'DESCRIPCION PARA PROMOVER PARTIDO', 300, 1, 10, 0, 0, 0, 0, 350),
 (6,  'Apostar', 'INDIVIDUAL', 'Apostar por el partido', 'DESCRIPCION APOSTAR', 0, 5, 0, 0, 0, 0, 0, 0),
 (7,  'Ascender', 'PASIVA', 'Ascender en el trabajo', 'DESCRIPCION ASCENDER', 0, 0, 0, 0, 0, 0, 0, 0),
 (8,  'ContratarRRPP', 'INDIVIDUAL', 'Contratar temporalmente a un relaciones públicas', 'DESCRIPCION CONTRATAR RRPP', 0, 0, 0, 0, 0, 0, 0, 0),
 (9,  'BeberCerveza', 'PARTIDO', 'Beber cerveza durante el partido', 'DESCRIPCION BEBER CERVEZA', 0, 0, 0, 0, 0, 0, 0, 0),
 (10, 'HablarSpeaker', 'PARTIDO', 'Hablar con el Speaker del estadio', 'DESCRIPCION HABLAR SPEAKER', 0, 0, 0, 0, 0, 0, 0, 0),
 (11, 'IniciarOla', 'PARTIDO', 'Iniciar una ola en la grada', 'DESCRIPCION INICIAR OLA', 0, 0, 0, 0, 0, 0, 0, 0),
 (12, 'PunteroLaser', 'PARTIDO', 'Molestar con el puntero láser a un jugador', 'DESCRIPCION PUNTERO LASER', 0, 0, 0, 0, 0, 0, 0, 0),
 (13, 'RetransmitirRRSS', 'PARTIDO', 'Retransmitir el partido por las redes sociales', 'DESCRIPCION RETRANSMITIR RRSS', 0, 0, 0, 0, 0, 0, 0, 0);

TRUNCATE `participaciones`;
INSERT INTO `participaciones` (`acciones_grupales_id_accion_grupal`, `usuarios_id_usuario`, `dinero_aportado`, `influencias_aportadas`, `animo_aportado`) VALUES
(2, 7, 100, 20, 20);

TRUNCATE `partidos`;
INSERT INTO `partidos` (`id_partido`, `equipos_id_equipo_1`, `equipos_id_equipo_2`, `hora`, `cronica`) VALUES
 -- Rojos vs. Verdes: ganaron los Rojos
 -- Negros vs. Blancos: ganaron los Negros
 (1, 1, 2, 1, 'Rojos(3) - Verdes (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 (2, 3, 4, 1, 'Negros(1) - Blancos (0); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 -- Rojos vs. Negros: ganaron los Rojos
 -- Verdes vs. Blancos: empate
 (3, 1, 3, 50, 'Rojos(2) - Negros (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 (4, 2, 4, 50, 'Verdes(0) - Blancos(0); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 -- Rojos vs. Blancos: empate
 -- Negros vs. Verdes: empate
 (5, 1, 4, 100, 'Rojos (3) - Blancos (3); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 (6, 3, 2, 100, 'Negros (1) - Verdes (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.'),
 -- Verdes vs. Rojos: PROXIMO PARTIDO
 -- Blancos vs. Negros: PROXIMO PARTIDO
 (7, 2, 1, 150, NULL),
 (8, 4, 3, 150, NULL),
 -- Negros vs. Rojos
 -- Blancos vs. Verdes
 (9,  3, 1, 200, NULL),
 (10, 4, 2, 200, NULL),
 -- Blancos vs. Rojos
 -- Verdes vs. Negros
 (11, 4, 1, 250, NULL),
 (12, 2, 3, 250, NULL);


TRUNCATE `recursos`;
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

 -- ----------------
 -- empresarios: 3
 -- movedoras: 3
 -- ultras: 4
 -- ----------------
TRUNCATE `usuarios`;
INSERT INTO `usuarios` (`id_usuario`, `equipos_id_equipo`, `nick`, `pass`, `email`, `personaje`, `nivel`) VALUES
 -- xaby: empresario
 (1, 1, 'xaby', 'xaby', 'xaby@xaby.com', 2, 5),
 -- marina: movedora
 (2, 2, 'marina', 'marina', 'marina@marina.com', 1, 5),
 -- arturo: empresario
 (3, 1, 'arturo', 'arturo', 'arturo@arturo.com', 2, 5),
 -- dani: ultra
 (4, 1, 'dani', 'dani', 'dani@dani.com', 0, 5),
 -- pedro: empresario
 (5, 2, 'pedro', 'pedro', 'pedro@pedro.com', 2, 5),
 -- manu: movedora
 (6, 3, 'manu', 'manu', 'manu@manu.com', 1, 5),
 -- rober: ultra
 (7, 2, 'rober', 'rober', 'rober@rober.com', 0, 5),
 -- marcos: ultra
 (8, 1, 'marcos', 'marcos', 'marcos@marcos.com', 0, 5),
 -- alex: movedora
 (9, 2, 'alex', 'alex', 'alex@alex.com', 1, 5),
 -- samu: ultra
 (10, 3, 'samu', 'samu', 'samu@samu.com', 0, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;