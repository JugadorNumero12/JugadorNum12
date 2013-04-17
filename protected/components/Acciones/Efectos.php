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
		
		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (
			'animo' => 25
		), 
		
		'HablarSpeaker' => array (
			'moral' => 20,
			'ofensivo' => 5
		), 
			
		'IniciarOla' => array (
			'moral' => 29
		), 
		
		'PunteroLaser' => array (
			'defensivo' => 35
		), 
		
		'RetransmitirRRSS' => array (
			'defensivo' => 3,
			'animo' => 12
		),

		// PASIVAS
		// -------------------------------------------------
			'Ascender' => array (
			'dinero_gen' => 12
		), 
	);
}
