<?php
/**** SCRIPT DE TURNOS DE PARTIDOS ****/

//1.- Seleccionar partidos para los que haya que generar un nuevo turno (activos)

//2.- Iterar sobre la lista de partidos resultante

//Selecciono partidos con hora mayor que la de la tabla <<Partidos>> y
//turnos entre 0 y 10
$tiempo=time();
$primerTurno=Partido::PRIMER_TURNO;
$ultimoTurno=Partido::ULTIMO_TURNO;
$busqueda=new CDbCriteria;
$busqueda->addCondition("'".$tiempo."' >= hora");
$busqueda->addCondition("turno >= '".$primerTurno."' ");
$busqueda->addCondition("turno <= '".$ultimoTurno."' ");
$partidos=Partidos::model()->findAll($busqueda);

foreach ($partidos as $partido)
{
	$partido = new Partido($partido->id_partido);
	$partido->jugarse();
}

/****/