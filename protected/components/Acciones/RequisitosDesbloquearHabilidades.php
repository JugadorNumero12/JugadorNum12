<?php

/** 
 * array estatico que define los requisitos para desbloquedar una habilidad
 *
 * listado de claves esperables : 
 *
 *  - nivel=>valor
 * 	- desbloqueadas_previas => array(Habilidades)
 *
 *
 * @package componentes\acciones
 */
class RequisitosDesbloquearHabilidades
{
	static $datos_acciones = array (

		// -------------------------------------------
		// NIVEL 1
		// -------------------------------------------
		// Individual
		'CrearseEspectativas' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array ()
		),

		// Individual
		'Apostar' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array ()
		), 

		// Partido
		'RetransmitirRRSS' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array ()
		),

		// Partido
		'BeberCerveza' => array (
			'nivel' => 1,
			'desbloqueadas_previas' => array ()
		), 

		// -------------------------------------------
		// NIVEL 2
		// -------------------------------------------

		// Grupal
		'Pintarse' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array ('BeberCerveza' => 'BeberCerveza')
		), 

		// Individual
		'EscribirBlog' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array ('RetransmitirRRSS' => 'RetransmitirRRSS')
		),

		// Partido
		'CorearEstadio' => array (
			'nivel' => 5,
			'desbloqueadas_previas' => array (),
		), 

		// -------------------------------------------
		// NIVEL 3
		// -------------------------------------------

		// Grupal 
		'AlquilarBus' => array (
			'nivel' => 10,
			'desbloqueadas_previas' => array (
				'Pintarse' => 'Pintarse',
			 	'CorearEstadio' => 'CorearEstadio')
		),

		// Grupal
		'ConciertoRock' => array (
			'nivel' => 10,
			'desbloqueadas_previas' => array ('CrearseEspectativas' => 'CrearseEspectativas')
		),

		// Pasiva
		'Ascender' => array (
			'nivel' => 10,
			'desbloqueadas_previas' => array ()
		), 

		// Grupal
		'PromoverPartido' => array (
			'nivel' => 10,
			'desbloqueadas_previas' => array ('EscribirBlog' => 'EscribirBlog')
		),

		// -------------------------------------------
		// NIVEL 4
		// -------------------------------------------

		// Individual
		'ContratarRRPP' => array (
			'nivel' => 15,
			'desbloqueadas_previas' => array ('Ascender' => 'Ascender')
		),

		// Individual
		'FalsearCuentas' => array (
			'nivel' => 15,
			'desbloqueadas_previas' => array ()
		),

		// Partido
		'DoblarApuesta' => array (
			'nivel' => 15,
			'desbloqueadas_previas' => array ('Apostar' => 'Apostar')
		),

		// Partido
		'ArrojarMechero' => array (
			'nivel' => 15,
			'desbloqueadas_previas' => array ('CorearEstadio' => 'CorearEstadio')
		), 

		// -------------------------------------------
		// NIVEL 5
		// -------------------------------------------
		
		// Grupal
		'FinanciarEvento' => array (
			'nivel'=> 25,
			'desbloqueadas_previas' => array (
				'FalsearCuentas' => 'FalsearCuentas',
				'ContratarRRPP' => 'ContratarRRPP',
				'Apostar' => 'Apostar')
		), 

		// Grupal
		'PublicarDifamaciones' => array (
			'nivel' => 25,
			'desbloqueadas_previas' => array ('PromoverPartido' => 'PromoverPartido')
		),

		// Partido
		'TumultoGradas' => array (
			'nivel' => 25,
			'desbloqueadas_previas' => array (
				'ArrojarMechero' => 'ArrojarMechero',
				'AlquilarBus' => 'AlquilarBus')
		),
		
		// -------------------------------------------
		// NIVEL 6
		// -------------------------------------------

		// Grupal
		'OrganizarHomenaje' => array (
			'nivel' => 35,
			'desbloqueadas_previas' => array (
				'ConciertoRock' => 'ConciertoRock',
				'AlquilarBus' => 'AlquilarBus')
		), 

		// Grupal
		'ConseguirInversores' => array (
			'nivel' => 35,
			'desbloqueadas_previas' => array (
				'FinanciarEvento' => 'FinanciarEvento',
				'ContratarRRPP' => 'ContratarRRPP')
		),

		// Grupal
		'HackearPlataforma' => array (
			'nivel' => 35,
			'desbloqueadas_previas' => array ()
		),

		// Partido
		'EntrevistaPartido' => array (
			'nivel' => 35,
			'desbloqueadas_previas' => array (
				'Ascender' => 'Ascender',
				'PromoverPartido' => 'PromoverPartido')
		),

		// -------------------------------------------
		// NIVEL 7
		// -------------------------------------------

		// Grupal	
		'IncentivoEconomico' => array (
			'nivel' => 45,
			'desbloqueadas_previas' => array (
				'FinanciarEvento' => 'FinanciarEvento', 
				'Ascender' => 'Ascender')
		), 
		
		// Partido
		'HablarSpeaker' => array (
			'nivel' => 45,
			'desbloqueadas_previas' => array ('EntrevistaPartido' => 'EntrevistaPartido')
		), 

		// Grupal
		'FinanciarPelicula' => array (
			'nivel' => 45,
			'desbloqueadas_previas' => array (
				'OrganizarHomenaje' => 'OrganizarHomenaje',
				'ConseguirInversores' => 'ConseguirInversores')
		),

		// -------------------------------------------
		// NIVEL 8
		// -------------------------------------------

		// Grupal
		'ObrasBeneficas' => array (
			'nivel' => 60,
			'desbloqueadas_previas' => array (
				'HablarSpeaker' => 'HablarSpeaker',
				'ConseguirInversores' => 'ConseguirInversores')
		),

		// Grupal
		'FicharJugador' => array (
			'nivel' => 60,
			'desbloqueadas_previas' => array ()
		),

		// ?
		'MandarJugadorHospital' => array (
			'nivel' => 60,
			'desbloqueadas_previas' => array ('TumultoGrada' => 'TumultoGrada')
		),

		// -------------------------------------------
		// NIVEL 9
		// -------------------------------------------

		// Grupal
		'ConstruirEstadio' => array (
			'nivel' => 75,
			'desbloqueadas_previas' => array (
				'FinanciarPelicula' => 'FinanciarPelicula',
				'FinanciarEvento' => 'FinanciarEvento',
				'ObrasBeneficas' => 'ObrasBeneficas',
				'FicharJugador' => 'FicharJugador')
		),

		// Pasiva
		'ContactarYakuza' => array (
			'nivel' => 75,
			'desbloqueadas_previas' => array ('HackearPlataforma' => 'HackearPlataforma')

		),

		// -------------------------------------------
		// NIVEL 10
		// -------------------------------------------

		// Pasiva
		'EquipamientoHeroe' => array (
			'nivel' => 99,
			'desbloqueadas_previas' => array ('ContactarYakuza' => 'ContactarYakuza')
		)
	);

}
