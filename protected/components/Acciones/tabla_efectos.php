<?php
static $datos_acciones = array (
	
	// GRUPALES
	// ------------------------------------------------
	'FinanciarEvento' => array (
		'aforo'=> 0.03,
		'ambiente' => 2
	), 
		
	'IncentivoEconomico' => array (
		'nivel_equipo' => 8,
		'bonus_creador' => array ('influencias' => 2)
	), 
	
	'OrganizarHomenaje' => array (
		'aforo' => 0.05,
		'bonus_creador' => array ('influencias_max' => 1)
	), 
		
	'Pintarse' => array (
		'ambiente' => 1,
		'animo' => 30,
		'bonus_creador' => array ('animo' => 15)
	), 
	
	'PromoverPartido' => array (
		'ambiente' => 4,
		'aforo' => 0.06
	), 
		
	// INDIVIDUALES
	// ------------------------------------------------
	'Apostar' => array (
		'dinero' => 600
	), 
	
	'CrearseEspectativas' => array (
		'animo' => 0.15
	),
		
	'ContratarRRPP' => array (
		'bonus_especial' => 1
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
	)

	// PASIVAS
	// -------------------------------------------------
		'Ascender' => array (
		'dinero_gen' => 0.12
	), 
)