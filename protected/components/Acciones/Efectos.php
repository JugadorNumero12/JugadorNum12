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
			'animo' => 1
		),

		// Individual
		'Apostar' => array (
			'dinero' => 600
		), 

		// Partido
		'RetransmitirRRSS' => array (
			'defensivo' => 3,
			'animo' => 10
		),

		//Partido 
		'BeberCerveza' => array (
			'animo' => 20
		), 

		// -------------------------------------------
		// NIVEL 2
		// -------------------------------------------

		// Grupal
		'Pintarse' => array (
			'ambiente' => 2,
			'animo' => 30,
			'moral'=> 200,
			'ofensivo'=>2,
			'bonus_creador' => array ('animo' => 15)
		), 

		// Pasiva
		'EscribirBlog' => array (
			'influencias_max' => 3
		),

		// Partido
		'CorearEstadio' => array (
			'moral' => 200
		), 

		// -------------------------------------------
		// NIVEL 3
		// -------------------------------------------

		// Grupal
		'AlquilarBus' => array (
			'aforo' => 100,
			'bonus_creador' => array ('animo_max' => 50)
		),

		// Grupal
		'ConciertoRock' => array (
			'aforo_base' => 100,
			'bonus_creador' => array ('dinero' => 50,'dinero_gen' => 15)
		), 

		// Pasiva
		'Ascender' => array (
			'dinero_gen' => 12
		), 


		// Grupal
		'PromoverPartido' => array (
			'ambiente' => 4,
			'aforo' => 0.15,
			'moral'=> 175
		), 

		// -------------------------------------------
		// NIVEL 4
		// -------------------------------------------

		// Individual
		'ContratarRRPP' => array (
			'bonus_jugador' => array ('influencias' => 1)
		),

		// Individual
		'FalsearCuentas' => array (
			'bonus_jugador' => array ('dinero' => 50)
		), 

		// Partido
		'DoblarApuesta' => array (
			'dinero' => 25
		), 

		// Partido
		'ArrojarMechero' => array (
			'defensivo' => 5
		), 

		// -------------------------------------------
		// NIVEL 5
		// -------------------------------------------

		// Grupal
		'FinanciarEvento' => array (
			'aforo'=> 0.15,
			'ambiente' => 2,
			'moral'=> 250,
		), 

		// Grupal
		'PublicarDifamaciones' => array (
			'nivel_equipo' => 3,
			'ambiente' => 150,
			'aforo' => 100,
		), 

		// Partido
		'TumultoGradas' => array (
			'ofensivo' => 3,
			'ambiente' => 100
		), 

		// -------------------------------------------
		// NIVEL 6
		// -------------------------------------------

		// Grupal
		'OrganizarHomenaje' => array (
			'aforo' => 0.2,
			'bonus_creador' => array ('influencias_max' => 1)
		), 

		// Grupal
		'ConseguirInversores' => array (
			'nivel_equipo' => 12,
			'bonus_creador' => array ('dinero' => 500 ,'dinero_gen' => 20)
		), 

		// Grupal
		'HackearPlataforma' => array (
			'nivel_equipo' => 5,
			'aforo' => 100,
		), 

		// Partido
		'EntrevistaPartido' => array (
			'ofensivo' => 3,
			'defensivo' => 3
		),

		// -------------------------------------------
		// NIVEL 7
		// -------------------------------------------
		
		// Grupal
		'IncentivoEconomico' => array (
			'nivel_equipo' => 8,
			'moral'=> 100,
			'bonus_creador' => array ('influencias' => 2)
		), 

		// Partido
		'HablarSpeaker' => array (
			'moral' => 200,
			'ofensivo' => 5
		), 

		// Grupal
		'FinanciarPelicula' => array (
			'aforo_base' => 100,
			'nivel_equipo' => 3,
			'bonus_creador' => array ('animo_gen' => 2,'dinero_gen' => 20)
		), 

		// -------------------------------------------
		// NIVEL 8
		// -------------------------------------------
		
		// Grupal
		'ObrasBeneficas' => array (
			'aforo_max' => 100,
			'bonus_creador' => array ('animo_gen' => 10)
		),

		// Grupal
		'FicharJugador' => array (
			'aforo_base' => 100,
			'nivel_equipo' => 3,
			'aforo' => 100,
			'bonus_creador' => array ('influencias_max' => 5)
		), 	

		// ?
		'MandarJugadorHospital' => array (
			'nivel_equipo' => 35
		),
		
		// -------------------------------------------
		// NIVEL 9
		// -------------------------------------------

		// Grupal
		'ConstruirEstadio' => array (
			'aforo_max' => 100,
			'moral' => 100,
			'nivel_equipo' => 2
		), 

		// Pasiva
		'ContactarYakuza' => array (
			'influencias_max' => 7,
			'influencias_gen' => 3
		),  

		// -------------------------------------------
		// NIVEL 10
		// -------------------------------------------

		// Pasiva
		'EquipHeroe' => array (
			'animo_max' => 50,
			'animo_gen' => 10,
			'influencias_max' => 5,
			'influencias_gen' => 2
		)
	);

}
