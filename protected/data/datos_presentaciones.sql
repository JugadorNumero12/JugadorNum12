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
 -- rojos
 (1, 3, 0, 0, 0, 0, 0),
 -- verdes
 (2, 4, 0, 0, 0, 0, 0),
 -- negros
 (3, 5, 0, 0, 0, 0, 0),
 -- blancos
 (4, 1, 0, 0, 0, 0, 0),
 -- azules
 (5, 2, 0, 0, 0, 0, 0),
 -- rosas
 (6, 6, 0, 0, 0, 0, 0),
 -- naranjas
 (7, 7, 0, 0, 0, 0, 0),
 -- amarillos
 (8, 8, 0, 0, 0, 0, 0);

TRUNCATE `desbloqueadas`;

TRUNCATE `equipos`;
INSERT INTO `equipos` (`partidos_id_partido`,`nombre`,`token`,`categoria`, `aforo_max`, `aforo_base`, `nivel_equipo`, `factor_ofensivo`, `factor_defensivo`) VALUES
 (0, 'Negros',   'negros',   1, 3600, 400, 10, 7, 7)
 (0, 'Verdes',   'verdes',   1, 3000, 500, 10, 7, 6),
 (0, 'Blancos',  'blancos',  1, 4000, 400, 9,  6, 8),
 (0, 'Azules',   'azules',   1, 3500, 300, 11, 6, 7),
 (0, 'Rosas',    'rosas',    1, 4000, 450, 10, 5, 5),
 (0, 'Naranjas', 'naranjas', 1, 3600, 500, 12, 7, 7),
 (0, 'Amarillos','amarillos',1, 3000, 350, 10, 6, 6),
 (0, 'Rojos',    'rojos',    1, 3000, 400, 12, 7, 5);

 -- ---------------------------------------------------------------------------------------------------------------------------------
 -- Tabla de costes para las habilidades 
 -- ---------------------------------------------------------------------------------------------------------------------------------
 --									dinero animo influencias | dinero_max animo_max influencias_max | participantes_max cooldown_fin
 -- Habilidades "empresariales" => 	 500 	3 		1 		 |	10000 		60 			12 			|	3 					200 			 	 
 -- Habilidades "ultra"			=>   200 	30 		0 		 |	4000 		600			1 			|   3 					200 			
 -- Habilidades "movedora"		=>   60 	15 		1 		 |  1200 		300 		24 			|   3   				200
 -- ----------------------------------------------------------------------------------------------------------------------------------
TRUNCATE `habilidades`;
INSERT INTO `habilidades` (`codigo`, `tipo`, `nombre`, `descripcion`, `dinero`, `animo`, `influencias`, `dinero_max`, `animo_max`, `influencias_max`, `participantes_max`, `cooldown_fin`) VALUES
 -- ---------------------
 -- Tipos de habilidades
 -- ---------------------
 -- GRUPALES 		0
 -- INDIVIDUALES 	1
 -- PARTIDO 		2
 -- PASIVAS 		3
 -- ---------------------
 ('FinanciarEvento', 0, 'Financiar un evento promocional', '"El marketing lo es todo: organizar un evento promocional ayudará a caldear el ambiente del próximo partido además de atraer más espectadores al estadio"', 500, 3, 1, 10000, 60, 10, 6, 600),
 ('IncentivoEconomico', 0, 'Incentivo económico a los jugadores', '"Los jugadores pueden correr más... sólo necesitan un pequeño empujoncito. Aumenta el nivel del equipo para el próximo partido; el impulsor del incentivo recupera influencias que haya destinado a otras acciones"', 500, 3, 1, 10000, 60, 15, 6, 600),
 ('OrganizarHomenaje', 0, 'Organizar homenaje a un jugador', '"Organiza un homenaje antes del partido a un jugador amado por la grada y conseguiras atraer a más espectadores para el próximo encuentro; el impulsor gana además influencias dentro del club si logra completar el homenaje"', 60, 15, 1, 1200, 300, 20, 6, 600),
 ('Pintarse', 0, 'Pintarse con los colores del equipo', '"Demuestra tu pasión por los colores de tu equipo. Sube el ambiente para el próximo partido"', 200, 30, 0, 400, 600, 15, 6, 600),
 ('PromoverPartido', 0, 'Promover el partido por las redes sociales', '"Comparte tu ilusión con tus amigos por internet."', 60, 15, 1, 1200, 300, 30, 6, 600),
 ('Apostar', 1, 'Apostar por el partido', '"Dale esa pizca extra de emoción."', 500, 3, 1, NULL, NULL, NULL, 1, 200),
 ('CrearseEspectativas', 1, 'Crearse espectativas para el próximo partido', '"Crearse espectativas para siguiente partido: obtienes inmediatamente puntos de animo"', 0, 0, 0, NULL, NULL, NULL, 1, 200),
 ('ContratarRRPP', 1, 'Contratar temporalmente a un relaciones públicas', '"Es muy duro movilizar las redes sociales tú sólo. Contrata temporalmente un ayudante."', 60, 15, 1, NULL, NULL, NULL, 1, 200),
 ('BeberCerveza', 2, 'Beber cerveza durante el partido', '"Recarga energías, te espera un partido largo."', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 ('HablarSpeaker', 2, 'Hablar con el Speaker del estadio', '"Apoya a tu equipo a lo grande: anímalo con los altavoces del propio estadio."', 30, 15, 1, NULL, NULL, NULL, 1, 10),
 ('IniciarOla', 2, 'Iniciar una ola en la grada', '"Mueve las gradas durante el partido."', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 ('PunteroLaser', 2, 'Molestar con el puntero láser a un jugador', '"La mejor defensa contra un lanzamiento de falta del rival. Molesta al jugador con un puntero láser."', 100, 30, 0, NULL, NULL, NULL, 1, 10),
 ('RetransmitirRRSS', 2, 'Retransmitir el partido por las redes sociales', '"Ocúpate de que el partido tenga repercusión."', 30, 15, 1, NULL, NULL, NULL, 1, 10),
 ('Ascender', 3, 'Ascender en el trabajo', '"A más dinero, más acciones podrás financiar."', 500, 3, 1, NULL, NULL, NULL, 1, NULL);

TRUNCATE `participaciones`;

TRUNCATE `partidos`;
INSERT INTO `partidos` (`equipos_id_equipo_1`, `equipos_id_equipo_2`, `hora`, `cronica`, `turno`, `ambiente`, `aforo_local`, `aforo_visitante`, `nivel_local`, `nivel_visitante`, `ofensivo_local`, `defensivo_local`, `ofensivo_visitante`, `defensivo_visitante`) VALUES
 /*-- Rojos vs. Verdes: ganaron los Rojos
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
 (1, 2, 1363778100, NULL, 0, 10, 400, 500, 12, 10, 7, 6, 7, 6),
 (3, 6, 1363778100, NULL, 0, 10, 400, 450, 10, 10, 7, 7, 5, 5),
 (4, 5, 1363778100, NULL, 0, 10, 400, 300, 9, 11, 6, 8, 6, 7),
 (7, 8, 1363778100, NULL, 0, 10, 500, 350, 12, 10, 7, 7, 6, 6),

 (2, 1, 1364737600, NULL, 0, 10, 100, 1000, 1, 1, 1, 1, 1, 1),
 (6, 3, 1364737600, NULL, 0, 10, 100, 1000, 1, 1, 1, 1, 1, 1),
 (5, 4, 1364737600, NULL, 0, 10, 100, 1000, 1, 1, 1, 1, 1, 1),
 (7, 8, 1364737600, NULL, 0, 10, 100, 1000, 1, 1, 1, 1, 1, 1);

TRUNCATE `recursos`;

TRUNCATE `usuarios`;

 SET FOREIGN_KEY_CHECKS = 1; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;