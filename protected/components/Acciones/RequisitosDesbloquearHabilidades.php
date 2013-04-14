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
			'nivel'=> 5,
			'desbloqueadas_previas' => array ('IncentivoEconomico' => 'IncentivoEconomico',
												'Apostar' => 'Apostar'),
		), 
			
		'IncentivoEconomico' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'OrganizarHomenaje' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
			
		'Pintarse' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'PromoverPartido' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
			
		// INDIVIDUALES
		// ------------------------------------------------
		'Apostar' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'CrearseEspectativas' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		),
			
		'ContratarRRPP' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		),
		
		//PARTIDO 
		// ------------------------------------------------
		'BeberCerveza' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'HablarSpeaker' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
			
		'IniciarOla' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'PunteroLaser' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
		
		'RetransmitirRRSS' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		),

		// PASIVAS
		// -------------------------------------------------
		'Ascender' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 
	);
}

?>
