<?php

/** 
 * Array estatico que define los valores contantes para las acciones
 *
 * listado de claves esperables
 *	
 * - aforo => valor
 * - ambiente => valor
 * - animo => valor
 * - animo_gen => valor
 * - animo_max => valor
 * - bonus_creador => array(claves espereables)
 * - bonus_jugador => array(claves esperables)
 * - defensivo => valor
 * - dinero => valor
 * - dinero_gen => valor
 * - influencias => valor
 * - influencias_gen => valor
 * - influencias_max => valor
 * - moral => valor
 * - nivel_equipo => valor
 * - ofensivo => valor
 *
 *
 * @package componentes\acciones
 */
class Efectos
{
	/** 
	 * @static
	 * @type object[] 
	 */
	static $datos_acciones = array (

		// -------------------------------------------
		// NIVEL 1
		// -------------------------------------------
		
		// Individual
		'CrearseEspectativas' => array (
			'animo' => 75
		),

		// Individual
		'Apostar' => array (
			'dinero' => 1000
		), 

		// Partido
		'RetransmitirRRSS' => array (
			'defensivo' => 1,
			'animo' => 25
		),

		//Partido 
		'BeberCerveza' => array (
			'ofensivo' => 1,
			'animo' => 50
		), 

		// -------------------------------------------
		// NIVEL 2
		// -------------------------------------------

		// Grupal
		'Pintarse' => array (
			'ambiente' => 10,
			'animo' => 100,
			'moral'=> 20,
			'ofensivo'=> 1,
			'bonus_creador' => array ('animo' => 150)
		), 

		// Pasiva
		'EscribirBlog' => array (
			'influencias_max' => 20
		),

		// Partido
		'CorearEstadio' => array (
			'moral' => 60
		), 

		// -------------------------------------------
		// NIVEL 3
		// -------------------------------------------

		// Grupal
		'AlquilarBus' => array (
			'aforo' => 60,
			'bonus_creador' => array ('animo_max' => 30)
		),

		// Grupal
		'ConciertoRock' => array (
			'aforo_base' => 120,
			'bonus_creador' => array ('dinero' => 10000,'dinero_gen' => 50)
		), 

		// Pasiva
		'Ascender' => array (
			'dinero_gen' => 150
		), 


		// Grupal
		'PromoverPartido' => array (
			'ambiente' => 20,
			'aforo' => 0.15,
			'moral'=> 75
		), 

		// -------------------------------------------
		// NIVEL 4
		// -------------------------------------------

		// Individual
		'ContratarRRPP' => array (
			'bonus_jugador' => array ('influencias' => 10)
		),

		// Individual
		'FalsearCuentas' => array (
			'bonus_jugador' => array ('dinero' => 500)
		), 

		// Partido
		'DoblarApuesta' => array (
			'animo' => 250
		), 

		// Partido
		'ArrojarMechero' => array (
			'defensivo' => 3
		), 

		// -------------------------------------------
		// NIVEL 5
		// -------------------------------------------

		// Grupal
		'FinanciarEvento' => array (
			'aforo'=> 0.25,
			'ambiente' => 8,
			'moral'=> 60,
		), 

		// Grupal
		'PublicarDifamaciones' => array (
			'nivel_equipo' => 3,
			'ambiente' => 40,
			'aforo' => 100,
		), 

		// Partido
		'TumultoGradas' => array (
			'ofensivo' => 4,
			'ambiente' => 25
		), 

		// -------------------------------------------
		// NIVEL 6
		// -------------------------------------------

		// Grupal
		'OrganizarHomenaje' => array (
			'aforo' => 0.6,
			'bonus_creador' => array ('influencias_max' => 11)
		), 

		// Grupal
		'ConseguirInversores' => array (
			'nivel_equipo' => 12,
			'bonus_creador' => array ('dinero' => 15000 ,'dinero_gen' => 90)
		), 

		// Grupal
		'HackearPlataforma' => array (
			'nivel_equipo' => 5,
			'aforo' => 80,
		), 

		// Partido
		'EntrevistaPartido' => array (
			'ofensivo' => 1,
			'defensivo' => 1
		),

		// -------------------------------------------
		// NIVEL 7
		// -------------------------------------------
		
		// Grupal
		'IncentivoEconomico' => array (
			'nivel_equipo' => 8,
			'moral'=> 65,
			'bonus_creador' => array ('influencias' => 80)
		), 

		// Partido
		'HablarSpeaker' => array (
			'moral' => 90,
			'ofensivo' => 5
		), 

		// Grupal
		'FinanciarPelicula' => array (
			'aforo_base' => 350,
			'nivel_equipo' => 3,
			'bonus_creador' => array ('animo_gen' => 25,'dinero_gen' => 900)
		), 

		// -------------------------------------------
		// NIVEL 8
		// -------------------------------------------
		
		// Grupal
		'ObrasBeneficas' => array (
			'aforo_max' => 200,
			'bonus_creador' => array ('animo_gen' => 85)
		),

		// Grupal
		'FicharJugador' => array (
			'aforo_base' => 100,
			'nivel_equipo' => 23,
			'aforo' => 100,
			'bonus_creador' => array ('influencias_max' => 48)
		), 	

		// ?
		'MandarJugadorHospital' => array (
			'nivel_equipo' => 25
		),
		
		// -------------------------------------------
		// NIVEL 9
		// -------------------------------------------

		// Grupal
		'ConstruirEstadio' => array (
			'aforo_max' => 700,
			'moral' => 140,
			'nivel_equipo' => 8
		), 

		// Pasiva
		'ContactarYakuza' => array (
			'influencias_max' => 650,
			'influencias_gen' => 40
		),  

		// -------------------------------------------
		// NIVEL 10
		// -------------------------------------------

		// Pasiva
		'EquipHeroe' => array (
			'animo_max' => 10000,
			'animo_gen' => 500,
			'influencias_max' => 300,
			'influencias_gen' => 10
		)
	);

}
