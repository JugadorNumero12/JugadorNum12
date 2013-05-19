<?php

/** 
 * Array estatico que define los los costes de las acciones
 *
 * listado de claves esperables
 *	
 * - animo => valor
 * - dinero => valor
 * - influencias => valor
 *
 * > Atencion : Usar como referencia, sin efectos reales
 *
 * @package componentes\acciones
 */
class Costes
{
	/** 
	 * @static
	 * @type object[] 
	 */
	static $costes_acciones = array (
		
		// GRUPALES
		// ------------------------------------------------
		'FinanciarEvento' => array (
			
		), 
			
		'IncentivoEconomico' => array (
			
		), 
		
		'OrganizarHomenaje' => array (

		), 
			
		'Pintarse' => array (

		), 
		
		'PromoverPartido' => array (

		), 
			
		// INDIVIDUALES
		// ------------------------------------------------
		'Apostar' => array (

		), 
		
		'CrearseEspectativas' => array (

		),
			
		'ContratarRRPP' => array (

		),
		
		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (

		), 
		
		'HablarSpeaker' => array (

		), 
			
		'IniciarOla' => array (

		), 
		
		'PunteroLaser' => array (

		), 
		
		'RetransmitirRRSS' => array (

		),

		// PASIVAS
		// -------------------------------------------------
			'Ascender' => array (

		), 
	);
}
