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


-- ------------------
-- ATENCION
-- ------------------
-- los usuarios por defecto comienzan en nivel 1 a 550exp para pasar a 2
-- --------------------------------------------------------------------


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
SET FOREIGN_KEY_CHECKS = 0; 

TRUNCATE `acciones_grupales`;


TRUNCATE `acciones_individuales`;

 
 -- ----------------------------------
 -- Rojos (1)   7 puntos 	+4 goles
 -- Negros (3) 	4 puntos 	-1 goles
 -- Verdes (2) 	2 puntos 	+2 goles
 -- Blancos (4) 2 puntos 	-2 goles
 -- ----------------------------------
TRUNCATE `clasificacion`;
INSERT INTO `clasificacion` (`equipos_id_equipo`, `posicion`, `puntos`, `ganados`, `empatados`, `perdidos`, `diferencia_goles`) VALUES
 -- negros
 (1, 1, 0, 0, 0, 0, 0),
 -- verdes
 (2, 3, 0, 0, 0, 0, 0),
 -- blancos
 (3, 8, 0, 0, 0, 0, 0),
 -- azules
 (4, 4, 0, 0, 0, 0, 0),
 -- rosas
 (5, 5, 0, 0, 0, 0, 0),
 -- naranjas
 (6, 6, 0, 0, 0, 0, 0),
 -- amarillos
 (7, 7, 0, 0, 0, 0, 0),
 -- rojos
 (8, 2, 0, 0, 0, 0, 0);

TRUNCATE `desbloqueadas`;
/*INSERT INTO `desbloqueadas` (`habilidades_id_habilidad`, `usuarios_id_usuario`) VALUES
 -- desbloqueadas de Xaby (empresario)
 (3, 1), (4, 1), (5, 1), (6, 1), (9, 1), (11, 1), 
 -- desbloqueadas de marina (movedora)
 (3, 2), (4, 2), (5, 2), (6, 2), (9, 2), (11, 2), 
  -- desbloqueadas de arturo (empresario)
 (3, 3), (4, 3), (5, 3), (6, 3), (9, 3), (11, 3), 
 -- desbloqueadas de dani (ultra)
 (3, 4), (4, 4), (5, 4), (6, 4), (9, 4), (11, 4),  
 -- desbloqueadas de pedro (empresario)
 (3, 5), (4, 5), (5, 5), (6, 5), (9, 5), (11, 5), 
 -- desbloqueadas de manu (movedora)
 (3, 6), (4, 6), (5, 6), (6, 6), (9, 6), (11, 6), 
 -- desbloqueadas de rober (ultra)
 (3, 7), (4, 7), (5, 7), (6, 7), (9, 7), (11, 7),  
 -- desbloqueadas de marcos (ultra)
 (3, 8), (4, 8), (5, 8), (6, 8), (9, 8), (11, 8),  
 -- desbloqueadas de alex (movedora)
 (3, 9), (4, 9), (5, 9), (6, 9), (9, 9), (11, 9), 
 -- desbloqueadas de samu (ultra)
 (3, 10), (4, 10), (5, 10), (6, 10), (9, 10), (11, 10);*/

TRUNCATE `equipos`;
INSERT INTO `equipos` (`partidos_id_partido`,`nombre`,`token`,`categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
 (0, 'Negros',   'negros',   1, 3600, 450, 10, 7, 7),
 (0, 'Verdes',   'verdes',   1, 3000, 500, 10, 7, 6),
 (0, 'Blancos',  'blancos',  1, 4000, 400, 9,  6, 8),
 (0, 'Azules',   'azules',   1, 3500, 300, 11, 6, 7),
 (0, 'Rosas',    'rosas',    1, 4000, 450, 10, 5, 5),
 (0, 'Naranjas', 'naranjas', 1, 3600, 500, 12, 7, 7),
 (0, 'Amarillos','amarillos',1, 3000, 350, 10, 6, 6),
 (0, 'Rojos',    'rojos',    1, 3000, 400, 12, 8, 6);


 -- ---------------------------------------------------------------------------------------------------------------------------------
 -- Tabla de costes para las habilidades 
 -- ---------------------------------------------------------------------------------------------------------------------------------
 --									dinero animo influencias | dinero_max animo_max influencias_max | participantes_max cooldown_fin
 -- Habilidades "empresariales" => 	 500 	3 		1 		 |	10000 		60 			12 			|	3 					200 			 	 
 -- Habilidades "ultra"			=>   200 	30 		0 		 |	4000 		600			1 			|   3 					200 			
 -- Habilidades "movedora"		=>   60 	15 		1 		 |  1200 		300 		24 			|   3   				200
 -- ----------------------------------------------------------------------------------------------------------------------------------
TRUNCATE `habilidades`;
INSERT INTO `habilidades` (`codigo`, `tipo`, `nombre`, `descripcion`, `dinero`, `animo`, `influencias`, `dinero_max`, `animo_max`, `influencias_max`, `participantes_max`, `cooldown_fin`, `token`) VALUES
 -- ---------------------
 -- Tipos de habilidades
 -- ---------------------
 -- GRUPALES 		0
 -- INDIVIDUALES 	1
 -- PARTIDO 		2
 -- PASIVAS 		3
 -- ---------------------
 ('FinanciarEvento', 0, 'Financiar un evento promocional', '"El marketing lo es todo: organizar un evento promocional ayudará a caldear el ambiente del próximo partido además de atraer más espectadores al estadio"', 500, 3, 1, 10000, 60, 35, 6, 600, 'financiar_evento'),
 ('IncentivoEconomico', 0, 'Incentivo económico a los jugadores', '"Los jugadores pueden correr más... sólo necesitan un pequeño empujoncito. Aumenta el nivel del equipo para el próximo partido; el impulsor del incentivo recupera influencias que haya destinado a otras acciones"', 500, 3, 1, 10000, 60, 35, 6, 600, 'incentivo_economico'),
 ('OrganizarHomenaje', 0, 'Organizar homenaje a un jugador', '"Organiza un homenaje antes del partido a un jugador amado por la grada y conseguiras atraer a más espectadores para el próximo encuentro; el impulsor gana además influencias dentro del club si logra completar el homenaje"', 60, 15, 1, 1200, 250, 40, 6, 600, 'organizar_homenaje'),
 ('Pintarse', 0, 'Pintarse con los colores del equipo', '"Demuestra tu pasión por los colores de tu equipo. Sube el ambiente para el próximo partido"', 200, 30, 0, 1000, 450, 20, 6, 600, 'pintarse_colores_equipo'),
 ('PromoverPartido', 0, 'Promover el partido por las redes sociales', '"Comparte tu ilusión con tus amigos por internet."', 60, 15, 1, 1200, 250, 45, 6, 600, 'publicitar_internet'),
 ('Apostar', 1, 'Apostar por el partido', '"Dale esa pizca extra de emoción."', 500, 3, 1, NULL, NULL, NULL, 1, 200, 'apostar'),
 ('CrearseEspectativas', 1, 'Crearse espectativas para el próximo partido', '"Crearse espectativas para siguiente partido: obtienes inmediatamente puntos de animo"', 0, 0, 0, NULL, NULL, NULL, 1, 200, '_sin_dibujo'),
 ('ContratarRRPP', 1, 'Contratar temporalmente a un relaciones públicas', '"Es muy duro movilizar las redes sociales tú sólo. Contrata temporalmente un ayudante."', 60, 15, 1, NULL, NULL, NULL, 1, 200, 'recopilar_influencias'),
 ('BeberCerveza', 2, 'Beber cerveza durante el partido', '"Recarga energías, te espera un partido largo."', 100, 30, 0, NULL, NULL, NULL, 1, 10, 'beber_cerveza'),
 ('HablarSpeaker', 2, 'Hablar con el Speaker del estadio', '"Apoya a tu equipo a lo grande: anímalo con los altavoces del propio estadio."', 30, 15, 1, NULL, NULL, NULL, 1, 10, 'hablar_speaker'),
 ('IniciarOla', 2, 'Iniciar una ola en la grada', '"Mueve las gradas durante el partido."', 100, 10, 0, NULL, NULL, NULL, 1, 10, 'corear_estadio'),
 ('PunteroLaser', 2, 'Molestar con el puntero láser a un jugador', '"La mejor defensa contra un lanzamiento de falta del rival. Molesta al jugador con un puntero láser."', 100, 30, 0, NULL, NULL, NULL, 1, 10, 'arrojar_mechero'),
 ('RetransmitirRRSS', 2, 'Retransmitir el partido por las redes sociales', '"Ocúpate de que el partido tenga repercusión."', 30, 15, 1, NULL, NULL, NULL, 1, 10, 'retransmitir_redes_sociales'),
 ('Ascender', 3, 'Ascender en el trabajo', '"A más dinero, más acciones podrás financiar."', 0, 0, 0, NULL, NULL, NULL, 1, NULL, 'ascender_trabajo');


TRUNCATE `participaciones`;


TRUNCATE `partidos`;
/*INSERT INTO `partidos` (`equipos_id_equipo_1`, `equipos_id_equipo_2`, `hora`, `cronica`, `turno`, `ambiente`, `aforo_local`, `aforo_visitante`, `nivel_local`, `nivel_visitante`, `ofensivo_local`, `defensivo_local`, `ofensivo_visitante`, `defensivo_visitante`) VALUES
 -- Rojos vs. Verdes: ganaron los Rojos
 -- Negros vs. Blancos: ganaron los Negros
 (1, 2, 1, 'Rojos(3) - Verdes (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 (3, 4, 1, 'Negros(1) - Blancos (0); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 -- Rojos vs. Negros: ganaron los Rojos
 -- Verdes vs. Blancos: empate
 (1, 3, 50, 'Rojos(2) - Negros (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 (2, 4, 50, 'Verdes(0) - Blancos(0); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 -- Rojos vs. Blancos: empate
 -- Negros vs. Verdes: empate
 (1, 4, 100, 'Rojos (3) - Blancos (3); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 (3, 2, 100, 'Negros (1) - Verdes (1); Lorem ipsum dolor sit amet, Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint est laborum.', 13, 0, 100, 100, 1, 1, 1, 1, 1, 1),
 -- Verdes vs. Rojos: PROXIMO PARTIDO
 -- Blancos vs. Negros: PROXIMO PARTIDO
 (2, 1, 150, NULL, 0, 10, 100, 1000, 1, 1, 1, 1, 1, 1),
 (4, 3, 150, NULL, 0, 55, 1000, 100, 1, 6, 6, 0, 1, 4),
 -- Negros vs. Rojos
 -- Blancos vs. Verdes
 (3, 1, 200, NULL, 0, 600, 10, 10, 6, 1, 1, 7, 1, 7),
 (4, 2, 200, NULL, 0, 7, 1000, 140, 2, 7, 1, 1, 1, 1),
 -- Blancos vs. Rojos
 -- Verdes vs. Negros
 (4, 1, 250, NULL, 0, 150, 160, 3457, 9, 9, 0, 1, 7, 0),
 (2, 3, 250, NULL, 0, 200, 125, 173, 4, 2, 4, 7, 3, 9),
 -- Partido para comprobar si los datos son reintroducidos correctamente
 (1, 2, 99999999999, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);*/

-- -------------------------------------------------------------------------------------------------------
 -- Recursos iniciales
 -- --------------------------------------------------------------------------------------------------------
 -- 				dinero dinero_gen influencias influencias_max influencias_gen animo animo_max animo_gen
 -- ultras: 		 2000 		5 			2 			2 				1 			300 	400 	15  
 -- movedoras: 		 600 		2 			11 			12 				3 			150 	250 	9
 -- empresarios: 	 5000 		16 			6 			8 				2 			30 		50 		1
 -- ---------------------------------------------------------------------------------------------------------
TRUNCATE `recursos`;
/*INSERT INTO `recursos` (`usuarios_id_usuario`, `dinero`, `dinero_gen`, `influencias`, `influencias_max`, `influencias_gen`, `animo`, `animo_max`, `animo_gen`) VALUES
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
 (10, 2000, 5, 2, 2, 1, 300, 400, 15);*/

 -- ----------------------
 -- Recuento de jugadores
 -- ----------------------
 -- empresarios: 3
 -- movedoras: 3
 -- ultras: 4
 -- ----------------------
TRUNCATE `usuarios`;
/*INSERT INTO `usuarios` (`equipos_id_equipo`, `nick`, `pass`, `email`, `personaje`, `nivel`, `exp`, `exp_necesaria`) VALUES
 -- xaby: empresario
 (1, 'xaby', '$2a$12$.ORtEsUunupLl48TgqWaS.TcQcWfRhq/LG2j2QtzBPQJparKHpz0e', 'xaby@xaby.com', 2, 1, 0, 550),
 -- marina: movedora
 (2, 'marina', '$2a$12$1HGd6WdDNpyG8wHu0vqPr.R7VhFJe7DutNgl06FziDCLV3OSYQvkC', 'marina@marina.com', 1, 1, 0, 550),
 -- arturo: empresario
 (1, 'arturo', '$2a$12$OQPWrk0fNriOXAqM4QW2seZ4.ITU7eTXfPaWR7.ehJViRwfG5L9lu', 'arturo@arturo.com', 2, 1, 0, 550),
 -- dani: ultra
 (1, 'dani', '$2a$12$Xqfm1L28HICeWypJtEEaFOcnJayZZXnp8s.tHAGEZzUaxz5.DvHoW', 'dani@dani.com', 0, 1, 0, 550),
 -- pedro: empresario
 (2, 'pedro', '$2a$12$0Z6Q7FdQUMKhz1gCuah4jegHD/mV87SE1TPQdb9O4ouy7Nh/YhF8y', 'pedro@pedro.com', 2, 1, 0, 550),
 -- manu: movedora
 (3, 'manu', '$2a$12$WDe3nJqlmi5.Jbvuzroo4.oW1oufdiQNb9cRW.lEXOA5LBmqO/uQ.', 'manu@manu.com', 1, 1, 0, 550),
 -- rober: ultra
 (2, 'rober', '$2a$12$EI56YEwNyV395M5rQsuk..HNYXFrOKFkwgzwkwvNoCgkBMe5Z1Nl.', 'rober@rober.com', 0, 1, 0, 550),
 -- marcos: ultra
 (1, 'marcos', '$2a$12$Pqca.CQrIopqmBV/9ON9E.RVOjv33YUX3D.1O8K3rhEa79Q.gDEV6', 'marcos@marcos.com', 0, 1, 0, 550),
 -- alex: movedora
 (2, 'alex', '$2a$12$muFItwmBUdoovIQ/91nWo.t7/fULQZdgmYA9HqlnNBE5.CY6.6p3S', 'alex@alex.com', 1, 1, 0, 550),
 -- samu: ultra
 (3, 'samu', '$2a$12$yq.TAX1ogUKvRI/fKYjHlOvVFt.kgEYuH2odUe/SWUubayucEJ.Y2', 'samu@samu.com', 0, 1, 0, 550);*/

 SET FOREIGN_KEY_CHECKS = 1; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;