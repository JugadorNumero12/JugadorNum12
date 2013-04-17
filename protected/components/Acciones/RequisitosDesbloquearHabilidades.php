<?php

/* array estatico que define los requisitos para desbloquedar una habilidad
 *
 * listado de claves esperables
 *		nivel=>valor
  * 	desbloqueadas_previas => array(claves esperables)
 */
class RequisitosDesbloquearHabilidades
{
	static $datos_acciones = array (
		
		// GRUPALES
		// ------------------------------------------------
		'FinanciarEvento' => array (
			'nivel'=> 2,
			'desbloqueadas_previas' => array ('OrganizarHomenaje' => 'OrganizarHomenaje'),
		), 
			
		'IncentivoEconomico' => array (
			'nivel' => 4,
			'desbloqueadas_previas' => array ('FinanciarEvento' => 'FinanciarEvento', 
												'Ascender' => 'Ascender',),
		), 
		
		'OrganizarHomenaje' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
			
		'Pintarse' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
		
		'PromoverPartido' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
			
		// INDIVIDUALES
		// ------------------------------------------------
		'Apostar' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
		
		'CrearseEspectativas' => array (
			'nivel' => 2,
			'desbloqueadas_previas' => array (),
		),
			
		'ContratarRRPP' => array (
			'nivel' => 3,
			'desbloqueadas_previas' => array ('Ascender' => 'Ascender',),
		),
		
		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
		
		'HablarSpeaker' => array (
			'nivel' => 3,
			'desbloqueadas_previas' => array ('RetransmitirRRSS' => 'RetransmitirRRSS',),
		), 
			
		'IniciarOla' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array (),
		), 
		
		'PunteroLaser' => array (
			'nivel' => 3,
			'desbloqueadas_previas' => array ('IniciarOla' => 'IniciarOla',),
		), 
		
		'RetransmitirRRSS' => array (
			'nivel' => 2,
			'desbloqueadas_previas' => array ('PromoverPartido' => 'PromoverPartido',),
		),

		// PASIVAS
		// -------------------------------------------------
		'Ascender' => array (
			'nivel' => 2,
			'desbloqueadas_previas' => array ('Apostar' => 'Apostar',),
		), 
	);
}

?>
