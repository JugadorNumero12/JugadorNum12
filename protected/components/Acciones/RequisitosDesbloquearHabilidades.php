<?php

/* array estatico que define los requisitos para desbloquedar una habilidad
 *
 * listado de claves esperables
 *		nivel=>valor
 */
class RequisitosDesbloquearHabilidades
{
	static $datos_acciones = array (
		
		// GRUPALES
		// ------------------------------------------------
		'FinanciarEvento' => array (
			'nivel'=> 0,
		), 
			
		'IncentivoEconomico' => array (
			'nivel' => 5,
		), 
		
		'OrganizarHomenaje' => array (
			'nivel' => 5,
		), 
			
		'Pintarse' => array (
			'nivel' => 5,
		), 
		
		'PromoverPartido' => array (
			'nivel' => 5,
		), 
			
		// INDIVIDUALES
		// ------------------------------------------------
		'Apostar' => array (
			'nivel' => 5,
		), 
		
		'CrearseEspectativas' => array (
			'nivel' => 5,
		),
			
		'ContratarRRPP' => array (
			'nivel' => 5,
		),
		
		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (
			'nivel' => 5,
		), 
		
		'HablarSpeaker' => array (
			'nivel' => 5,
		), 
			
		'IniciarOla' => array (
			'nivel' => 5,
		), 
		
		'PunteroLaser' => array (
			'nivel' => 5,
		), 
		
		'RetransmitirRRSS' => array (
			'nivel' => 5,
		),

		// PASIVAS
		// -------------------------------------------------
		'Ascender' => array (
			'nivel' => 5,
		), 
	);
}

?>
