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
		
		// -------------------------------------------
		// NIVEL 1
		// -------------------------------------------
		
		// Individual
		'CrearseEspectativas' => array (
			'dinero' => 650
		),

		// Individual
		'Apostar' => array (
			'animo' => 150
		), 

		// Partido
		'RetransmitirRRSS' => array (
			'animo' => 40
		),

		//Partido 
		'BeberCerveza' => array (
			'dinero' => 1000
		), 

		// -------------------------------------------
		// NIVEL 2
		// -------------------------------------------

		// Grupal
		'Pintarse' => array (
			'dinero' => 10000,
			'animo' => 2000,
			'influencias'=> 40,
		), 

		// Pasiva
		'EscribirBlog' => array (
			'dinero' => 3500,
			'animo' => 250
		),

		// Partido
		'CorearEstadio' => array (
			'animo' => 150,
			'influencias' => 10
		), 

		// -------------------------------------------
		// NIVEL 3
		// -------------------------------------------

		// Grupal
		'AlquilarBus' => array (
			'dinero' => 20000,
			'animo' => 1800,
			'infuencias' => 9
		),

		// Grupal
		'ConciertoRock' => array (
			'dinero' => 24000,
			'animo' => 1500,
			'influencias' => 30
		), 

		// Pasiva
		'Ascender' => array (
			'influencias' => 75
		), 


		// Grupal
		'PromoverPartido' => array (
			'dinero' => 10000,
			'animo' => 3500,
			'influencias'=> 150
		), 

		// -------------------------------------------
		// NIVEL 4
		// -------------------------------------------

		// Individual
		'ContratarRRPP' => array (
			'dinero' => 2000
		),

		// Individual
		'FalsearCuentas' => array (
			'influencias' => 40
		), 

		// Partido
		'DoblarApuesta' => array (
			'dinero' => 750
		), 

		// Partido
		'ArrojarMechero' => array (
			'animo' => 250
		), 

		// -------------------------------------------
		// NIVEL 5
		// -------------------------------------------

		// Grupal
		'FinanciarEvento' => array (
			'dinero'=> 53000,
			'animo' => 3750,
			'influencias'=> 280,
		), 

		// Grupal
		'PublicarDifamaciones' => array (
			'dinero' => 28500,
			'animo' => 5500,
			'influencias' => 350,
		), 

		// Partido
		'TumultoGradas' => array (
			'animo' => 265
		), 

		// -------------------------------------------
		// NIVEL 6
		// -------------------------------------------

		// Grupal
		'OrganizarHomenaje' => array (
			'dinero' => 44000,
			'animo' => 8500
			'influencias' => 350 
		), 

		// Grupal
		'ConseguirInversores' => array (
			'dinero' => 52000,
			'animo' => 7000
			'influencias' => 550 
		), 

		// Grupal
		'HackearPlataforma' => array (
			'dinero' => 28000,
			'animo' => 10000
			'influencias' => 200
		), 

		// Partido
		'EntrevistaPartido' => array (
			'animo' => 200,
			'influencias' => 50
		),

		// -------------------------------------------
		// NIVEL 7
		// -------------------------------------------
		
		// Grupal
		'IncentivoEconomico' => array (
			'dinero' => 60000,
			'animo' => 9000
			'influencias' => 325
		), 

		// Partido
		'HablarSpeaker' => array (
			'dinero' => 5000,
			'animo' => 225
		), 

		// Grupal
		'FinanciarPelicula' => array (
			'dinero' => 75000,
			'animo' => 7500,
			'influencias' => 400
		), 

		// -------------------------------------------
		// NIVEL 8
		// -------------------------------------------
		
		// Grupal
		'ObrasBeneficas' => array (
			'dinero' => 100000,
			'animo' => 10000,
			'influencias' => 550
		),

		// Grupal
		'FicharJugador' => array (
			'dinero' => 350000,
			'animo' => 6000,
			'influencias' => 550
		), 	

		// ?
		'MandarJugadorHospital' => array (
			'dinero' => 60000,
			'animo' => 16000,
			'influencias' => 500
		),
		
		// -------------------------------------------
		// NIVEL 9
		// -------------------------------------------

		// Grupal
		'ConstruirEstadio' => array (
			'dinero' => 750000,
			'animo' => 17000,
			'influencias' => 900
		), 

		// Pasiva
		'ContactarYakuza' => array (
			'dinero' => 300000,
			'animo' => 8000,
		),  

		// -------------------------------------------
		// NIVEL 10
		// -------------------------------------------

		// Pasiva
		'EquipHeroe' => array (
			'dinero' => 1000000,
			'animo' => 25000,
			'influencias' => 1000
		)
	);
}
