-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net

-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-12-2012 a las 13:37:32
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7
-- Base de datos: `juego`

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- TODO: COMPROBAR LIMITES DE RECURSOS EN PARTICIPACIONES 

-- ------------------------------------------------------------------------------------
-- Vaciado de tablas
--
-- delete from <<tabla>> where 1
--  borra los n registros almacenados, el siguiente registro que guardemos sera el n+1
-- 
-- truncate <<tabla>>
--  borra los n registros almacenados, el siguiente registro que guardemos sera el 1
-- ------------------------------------------------------------------------------------

-- ---------------------
-- CONSTANTES DEFINIDAS 
-- ---------------------
-- Tipos de habilidades
--  GRUPALES 		= 0
--  INDIVIDUALES 	= 1
--  PARTIDO 		= 2
--  PASIVAS 		= 3
--
-- Tipos de personajes
--  ULTRA 			= 0
--  MOVEDORA 		= 1
--  EMPRESARIO 		= 2
-- ---------------------

-- ------------------------------------------------------------
-- ------------ RELLENADO DE TABLAS ---------------------------
-- ------------------------------------------------------------

 -- -----------------------------------------------------
 -- Proximos partidos + seguidores con habilidades grupales
 -- -----------------------------------------------------
 -- Verdes vs. Rojos   (partido 7)
 -- Blancos vs. Negros (partido 8)
 -- -----------------------------------------------------
 -- Rojos:
 -- 	xaby (1) 	=> habilidades: 1, 2, 3
 -- 	arturo (3) 	=> habilidades: 1, 2, 3
 --	 	dani(4)		=> habilidades: 4
 --  	marcos(8)   => habilidades: 4
 -- Verdes:
 -- 	marina(2)	=> habilidades: 3, 4, 5
 -- 	pedro (5)	=> habilidades: 1, 2, 3
 -- 	rober(7)	=> habilidades: 4
 -- 	alex(9) 	=> habilidades: 3, 4, 5
 -- Negros: 
 -- 	manu(6)	    => habilidades: 3, 4, 5 
 -- 	samu(10)    => habilidades: 4
 -- -----------------------------------------------------
 -- NOTA: todas las acciones en curso estan completadas al 50%
 -- -----------------------------------------------------
TRUNCATE `acciones_grupales`;
INSERT INTO `acciones_grupales` (`id_accion_grupal`, `usuarios_id_usuario`, `habilidades_id_habilidad`, `equipos_id_equipo`, `influencias_acc`, `animo_acc`, `dinero_acc`, `jugadores_acc`, `finalizacion`, `completada`) VALUES
 -- arturo, habilidad 2 (hab. de perfil empresarial)
 (1, 3, 2, 1, 6, 30, 5000, 2, 50, 0),
 -- COMPLETADA: xaby, habilidad 1 (hab. de perfil empresarial)
 (2, 1, 1, 1, 12, 60, 10000, 1, 50, 1),
 -- marina, habilidad 4 (hab. de perfil ultra)
 (3, 2, 4, 2, 1, 300, 400, 2, 50, 0),
 -- alex, habilidad 3 (hab. de perfil movedora)
 (4, 9, 3, 2, 12, 150, 600, 1, 50, 0),
 -- COMPLETADA: manu, habilidad 3 (hab. de perfil movedora)
 (5, 6, 3, 3, 24, 300, 1200, 1, 50, 1),
 -- samu, habilidad 4 (hab. de perfil ultra)
 (6, 10, 4, 3, 1, 1, 400, 1, 50, 0),
 -- marina, habilidad 5 (hab. de perfil movedora)
 (7, 2, 5, 2, 12, 150, 600, 2, 50, 0),
 -- COMPLETADA: dani, habilidad 4 (hab. de perfil ultra)
 (8, 4, 4, 1, 1, 600, 400, 1, 50, 1),
 -- marcos, habilidad 4 (hab. de perfil ultra)
 (9, 8, 4, 1, 1, 200, 400, 2, 50, 0),
 -- COMPLETADA: pedro, habilidad 1 (hab. de perfil empresario)
 (10, 5, 1, 2, 12, 60, 10000, 1, 50, 1);

 -- -------------------------------------------------
 -- Acciones individuales desbloqeuadas 6,7,8
 -- ------------------------------------------------- 
 -- jugador	1 (empresario) 	=> habilidades: 6, 7, 8
 -- jugador 3 (empresario) 	=> habilidades: 6, 7, 8
 --	jugador 4 (ultra)		=> habilidades: 6, 7
 -- jugador 8 (utra)   		=> habilidades: 6, 7
 -- jugador 2 (movedora) 	=> habilidades:    7, 8
 -- jugador 5 (empresario)	=> habilidades: 6, 7, 8
 -- jugador 7 (ultra)		=> habilidades: 6, 7
 -- jugador 9 (movedora) 	=> habilidades:    7, 8 
 -- jugador 6 (movedora) 	=> habilidades:    7, 8 
 -- jugador 10 (ultra)    	=> habilidades: 6, 7
 -- -----------------------------------------------------
TRUNCATE `acciones_individuales`;
INSERT INTO `acciones_individuales` (`habilidades_id_habilidad`, `usuarios_id_usuario`, `cooldown`) VALUES
 (6, 1, 200),
 (7, 1, 200),
 (7, 3, 200),
 (7, 4, 200),
 (8, 2, 200),
 (6, 7, 200),
 (7, 7, 200),
 (8, 9, 200),
 (7, 10, 200);
 
 -- ----------------------------------
 -- Rojos (1)   7 puntos 	+4 goles
 -- Negros (3) 	4 puntos 	-1 goles
 -- Verdes (2) 	2 puntos 	+2 goles
 -- Blancos (4) 2 puntos 	-2 goles
 -- ----------------------------------
TRUNCATE `clasificacion`;
INSERT INTO `clasificacion` (`equipos_id_equipo`, `posicion`, `puntos`, `ganados`, `empatados`, `perdidos`, `diferencia_goles`) VALUES
 -- rojos
 (1, 1, 7, 2, 1, 0, 4),
 -- verdes
 (2, 3, 2, 0, 2, 1, 2),
 -- negros
 (3, 2, 4, 1, 1, 1, -1),
 -- blancos
 (4, 4, 2, 0, 2, 1, -2);

TRUNCATE `desbloqueadas`;
INSERT INTO `desbloqueadas` (`habilidades_id_habilidad`, `usuarios_id_usuario`) VALUES
 -- desbloqueadas de Xaby (empresario)
 (1, 1), (2, 1), (3, 1), (6, 1), (7, 1), (8, 1), (14, 1),
 -- desbloqueadas de marina (movedora)
 (3, 2), (4, 2), (5, 2), (7, 2), (8, 2), (10, 2), (13, 2),
 -- desbloqueadas de arturo (empresario)
 (1, 3), (2, 3), (3, 3), (6, 3), (7, 3), (8, 3), (14, 3),
 -- desbloqueadas de dani (ultra)
 (4, 4), (6, 4), (7, 4), (9, 4), (11, 4), (12, 4), (13, 4), (14, 4), 
 -- desbloqueadas de pedro (empresario)
 (1, 5), (2, 5), (3, 5), (6, 5), (7, 5), (8, 5), (14, 5),
 -- desbloqueadas de manu (movedora)
 (3, 6), (4, 6), (5, 6), (7, 6), (8, 6), (10, 6), (13, 6),
 -- desbloqueadas de rober (ultra)
 (4, 7), (6, 7), (7, 7), (9, 7), (11, 7), (12, 7), (13, 7), (14, 7), 
 -- desbloqueadas de marcos (ultra)
 (4, 8), (6, 8), (7, 8), (9, 8), (11, 8), (12, 8), (13, 8), (14, 8), 
 -- desbloqueadas de alex (movedora)
 (3, 9), (4, 9), (5, 9), (7, 9), (8, 9), (10, 9), (13, 9),
 -- desbloqueadas de samu (ultra)
 (4, 10), (6, 10), (7, 10), (9, 10), (11, 10), (12, 10), (13, 10), (14, 10);

TRUNCATE `equipos`;
INSERT INTO `equipos` (`id_equipo`, `partidos_id_partido`,`nombre`, `categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
 (1, 7, 'Rojos',   1, 3000, 400, 12, 7, 6),
 (2, 7, 'Verdes',  1, 3000, 500, 10, 7, 6),
 (3, 8, 'Negros',  1, 3600, 400, 10, 7, 7),
 (4, 8, 'Blancos', 1, 4000, 400, 9,  6, 8);

 -- ---------------------------------------------------------------------------------------------------------------------------------
 -- Tabla de costes para las habilidades 
 -- ---------------------------------------------------------------------------------------------------------------------------------
 --									dinero animo influencias | dinero_max animo_max influencias_max | participantes_max cooldown_fin
 -- Habilidades "empresariales" => 	 500 	3 		1 		 |	10000 		60 			12 			|	3 					200 			 	 
 -- Habilidades "ultra"			=>   200 	30 		0 		 |	4000 		600			1 			|   3 					200 			
 -- Habilidades "movedora"		=>   60 	15 		1 		 |  1200 		300 		24 			|   3   				200
 -- ----------------------------------------------------------------------------------------------------------------------------------
TRUNCATE `habilidades`;
INSERT INTO `habilidades` (`id_habilidad`, `codigo`, `tipo`, `nombre`, `descripcion`, `dinero`, `animo`, `influencias`, `dinero_max`, `animo_max`, `influencias_max`, `participantes_max`, `cooldown_fin`) VALUES
 -- ---------------------
 -- Tipos de habilidades
 -- ---------------------
 -- GRUPALES 		0
 -- INDIVIDUALES 	1
 -- PARTIDO 		2
 -- PASIVAS 		3
 -- ---------------------
 (1, 'FinanciarEvento', 0, 'Financiar un evento promocional', '"El marketing lo es todo: organizar un evento promocional ayudará a caldear el ambiente del próximo partido además de atraer más espectadores al estadio"', 500, 3, 1, 10000, 60, 12, 3, 200),
 (2, 'IncentivoEconomico', 0, 'Incentivo económico a los jugadores', '"Los jugadores pueden correr más... sólo necesitan un pequeño empujoncito. Aumenta el nivel del equipo para el próximo partido; el impulsor del incentivo recupera influencias que haya destinado a otras acciones"', 500, 3, 1, 10000, 60, 12, 3, 200),
 (3, 'OrganizarHomenaje', 0, 'Organizar homenaje a un jugador', '"Organiza un homenaje antes del partido a un jugador amado por la grada y conseguiras atraer a más espectadores para el próximo encuentro; el impulsor gana además influencias dentro del club si logra completar el homenaje"', 60, 15, 1, 1200, 300, 24, 3, 200),
 (4, 'Pintarse', 0, 'Pintarse con los colores del equipo', '"DESCRIPCION PARA PINTARSE"', 200, 30, 0, 400, 600, 1, 3, 200),
 (5, 'PromoverPartido', 0, 'Promover el partido por las redes sociales', '"DESCRIPCION PARA PROMOVER PARTIDO"', 60, 15, 1, 1200, 300, 24, 3, 200),
 (6, 'Apostar', 1, 'Apostar por el partido', '"DESCRIPCION APOSTAR"', 500, 3, 1, NULL, NULL, NULL, 1, 200),
 (7, 'CrearseEspectativas', 1, 'Crearse espectativas para el próximo partido', '"Crearse espectativas para siguiente partido: obtienes inmediatamente puntos de animo"', 0, 0, 0, NULL, NULL, NULL, 1, 200),
 (8, 'ContratarRRPP', 1, 'Contratar temporalmente a un relaciones públicas', '"DESCRIPCION CONTRATAR RRPP"', 60, 15, 1, NULL, NULL, NULL, 1, 200),
 (9, 'BeberCerveza', 2, 'Beber cerveza durante el partido', '"DESCRIPCION BEBER CERVEZA"', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 (10, 'HablarSpeaker', 2, 'Hablar con el Speaker del estadio', '"DESCRIPCION HABLAR SPEAKER"', 30, 15, 1, NULL, NULL, NULL, 1, 10),
 (11, 'IniciarOla', 2, 'Iniciar una ola en la grada', '"DESCRIPCION INICIAR OLA"', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 (12, 'PunteroLaser', 2, 'Molestar con el puntero láser a un jugador', '"DESCRIPCION PUNTERO LASER"', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 (13, 'RetransmitirRRSS', 2, 'Retransmitir el partido por las redes sociales', '"DESCRIPCION RETRANSMITIR RRSS"', 30, 15, 1, NULL, NULL, NULL, 1, 10),
 (14, 'Ascender', 3, 'Ascender en el trabajo', '"DESCRIPCION ASCENDER"', 500, 3, 1, NULL, NULL, NULL, 1, NULL);

 -- ----------------------------------------------------
 -- Acciones grupales abiertas y completadas
 -- ----------------------------------------------------
 -- Rojos (jugadores 1, 3, 4, 8) 
 -- 	1)  hab. 2 empresarial
 --		2)  hab. 1 empresarial 	[COMPLETADA]
 --     8)  hab. 4 ultra 		[COMPLETADA] 
 -- 	9)  hab. 4 ultra
 -- Verdes (jugadores 2, 5, 7, 9)
 --		3)  hab. 4 ultra
 --     4)  hab. 3 movedora
 --     7)  hab. 5 movedora
 -- 	10) hab. 1 empresarial 	[COMPLETADA]
 -- Negros (jugadores 6, 10)
 -- 	5)  hab. 3 movedora 	[COMPLETADA]
 --     6)  hab. 4 ultra
 -- -----------------------------------------------------
 -- Coste de las habilidades
 -- -----------------------------------------------------
 -- empresariales:  10000 dinero; 12 influencias; 60 animo 
 -- ultras: 		4000 dinero;  1 influencias; 600 animo
 -- movedora: 		1200 dinero; 24 influencias; 300 animo 
 -- ------------------------------------------------------
TRUNCATE `participaciones`;
INSERT INTO `participaciones` (`acciones_grupales_id_accion_grupal`, `usuarios_id_usuario`, `dinero_aportado`, `influencias_aportadas`, `animo_aportado`) VALUES
 (1, 1, 4000, 0, 10),
 (1, 3, 0, 4, 10),
 (1, 4, 1000, 2, 10),
 (2, 3, 4000, 10, 60),
 (2, 8, 6000, 2, 0),
 (3, 2, 200, 1, 200),
 (3, 5, 0, 0, 100),
 (3, 7, 200, 0, 0),
 (4, 2, 300, 4, 150),
 (4, 9, 300, 8, 0),
 (5, 6, 1000, 20, 250),
 (5, 10, 200, 4, 50),
 (6, 10, 400, 1, 1),
 (7, 5, 200, 4, 50),
 (7, 7, 200, 4, 50),
 (7, 9, 200, 4, 50),
 (8, 1, 400, 0, 0),
 (8, 8, 0, 1, 600),
 (9, 3, 200, 0, 100),
 (9, 4, 200, 0, 0),
 (9, 8, 0, 1, 100),
 (10, 2, 4000, 5, 45),
 (10, 9, 6000, 7, 15);

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

-- -------------------------------------------------------------------------------------------------------
 -- Recursos iniciales
 -- --------------------------------------------------------------------------------------------------------
 -- 				dinero dinero_gen influencias influencias_max influencias_gen animo animo_max animo_gen
 -- ultras: 		 2000 		5 			2 			2 				1 			300 	400 	15  
 -- movedoras: 		 600 		2 			11 			12 				3 			150 	250 	9
 -- empresarios: 	 5000 		16 			6 			8 				2 			30 		50 		1
 -- ---------------------------------------------------------------------------------------------------------
TRUNCATE `recursos`;
INSERT INTO `recursos` (`usuarios_id_usuario`, `dinero`, `dinero_gen`, `influencias`, `influencias_max`, `influencias_gen`, `animo`, `animo_max`, `animo_gen`) VALUES
 -- xaby: empresario
 (1, 5000, 16, 6, 8, 2, 30, 50, 1),
 -- marina: movedora
 (2, 600, 2, 11, 12, 3, 150, 250, 9),
 -- arturo: empresario
 (3, 5000, 16, 6, 8, 2, 30, 50, 1),
 -- dani: ultra
 (4, 2000, 5, 2, 2, 1, 300, 400, 15),
 -- pedro: empresario
 (5, 5000, 16, 6, 8, 2, 30, 50, 1),
 -- manu: movedora
 (6, 600, 2, 11, 12, 3, 150, 250, 9),
 -- rober: ultra
 (7, 2000, 5, 2, 2, 1, 300, 400, 15),
 -- marcos: ultra
 (8, 2000, 5, 2, 2, 1, 300, 400, 15),
 -- alex: movedora
 (9, 600, 2, 11, 12, 3, 150, 250, 9),
 -- samu: ultra
 (10, 2000, 5, 2, 2, 1, 300, 400, 15);

 -- ----------------------
 -- Recuento de jugadores
 -- ----------------------
 -- empresarios: 3
 -- movedoras: 3
 -- ultras: 4
 -- ----------------------
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