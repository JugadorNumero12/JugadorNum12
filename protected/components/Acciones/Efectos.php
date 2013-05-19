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
		
		// GRUPALES
		// ------------------------------------------------
		'FinanciarEvento' => array (
			'aforo'=> 0.15,
			'ambiente' => 2,
			'moral'=> 250,
		), 
			
		'IncentivoEconomico' => array (
			'nivel_equipo' => 8,
			'moral'=> 100,
			'bonus_creador' => array ('influencias' => 2)
		), 
		
		'OrganizarHomenaje' => array (
			'aforo' => 0.2,
			'bonus_creador' => array ('influencias_max' => 1)
		), 
			
		'Pintarse' => array (
			'ambiente' => 2,
			'animo' => 30,
			'moral'=> 200,
			'ofensivo'=>2,
			'bonus_creador' => array ('animo' => 15)
		), 
		
		'PromoverPartido' => array (
			'ambiente' => 4,
			'aforo' => 0.15,
			'moral'=> 175
		), 

		'ConseguirInversores' => array (
			'nivel_equipo' => 12,
			'bonus_creador' => array ('dinero' => 500 ,'dinero_gen' => 20)
		), 
		
		'ConstruirEstadio' => array (
			'aforo_max' => 100,
			'moral' => 100,
			'nivel_equipo' => 2
		), 

		'FicharJugador' => array (
			'aforo_base' => 100,
			'nivel_equipo' => 3,
			'aforo' => 100,
			'bonus_creador' => array ('influencias_max' => 5)
		), 	

		'FinanciarPelicula' => array (
			'aforo_base' => 100,
			'nivel_equipo' => 3,
			'bonus_creador' => array ('animo_gen' => 2,'dinero_gen' => 20)
		), 

		'ConciertoRock' => array (
			'aforo_base' => 100,
			'bonus_creador' => array ('dinero' => 50,'dinero_gen' => 15)
		), 

		'HackearPlataforma' => array (
			'nivel_equipo' => 5,
			'aforo' => 100,
		), 

		'PublicarDifamaciones' => array (
			'nivel_equipo' => 3,
			'ambiente' => 150,
			'aforo' => 100,
		), 

		// INDIVIDUALES
		// ------------------------------------------------
		'Apostar' => array (
			'dinero' => 600
		), 
		
		'CrearseEspectativas' => array (
			'animo' => 1
		),
			
		'ContratarRRPP' => array (
			'bonus_jugador' => array ('influencias' => 1)
		),

		'FalsearCuentas' => array (
			'bonus_jugador' => array ('dinero' => 50)
		), 

		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (
			'animo' => 20
		), 
		
		'HablarSpeaker' => array (
			'moral' => 200,
			'ofensivo' => 5
		), 
			
		'CorearEstadio' => array (
			'moral' => 200
		), 
		
		'ArrojarMechero' => array (
			'defensivo' => 5
		), 
		
		'RetransmitirRRSS' => array (
			'defensivo' => 3,
			'animo' => 10
		),

		'DoblarApuesta' => array (
			'dinero' => 25
		), 

		'Entrevista' => array (
			'ofensivo' => 3,
			'defensivo' => 3
		), 

		// PASIVAS
		// -------------------------------------------------
		'Ascender' => array (
			'dinero_gen' => 12
		), 

		'EquipHeroe' => array (
			'animo_max' => 50,
			'animo_gen' => 10,
			'influencias_max' => 5,
			'influencias_gen' => 2
		), 

		'EscribirBlog' => array (
			'influencias_max' => 3
		),

		'ContactarYakuza' => array (
			'influencias_max' => 7,
			'influencias_gen' => 3
		),  
	);
}
