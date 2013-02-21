<?php

/* Esta api permite llamar y testear los diferentes scripts. */
class ScriptsController extends Controller
{
	/**
	 * @return array de filtros para actions
	 */
	public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Esta función es usada por el filtro "accessControl".
	 * @return array con las reglas de control de acceso
	 */
	public function accessRules()
	{
		return array(
			array('allow', // Permite realizar a todos los usuarios
				'users'=>array('*'),
			),
			array('deny',  // Niega acceso al resto de usuarios. Se deja por "seguridad"
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Selecciona los partidos en juego y ejecuta sus turnos correspondientes.
	 *
	 * @ruta jugadorNum12/scriptsApi/jugarPartido
	 */
	public function actionEjecutarTurno()
	{
		Yii::import('application.components.Partido');

		$tiempo=time();
		$primerTurno=Partido::PRIMER_TURNO;
		$ultimoTurno=Partido::ULTIMO_TURNO;
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= hora');
		$busqueda->addCondition('turno >= :bPrimerTurno');
		$busqueda->addCondition('turno <= :bUltimoTurno');
		$busqueda->params = array(':bTiempo' => $tiempo,
								'bPrimerTurno' => $primerTurno,
								'bUltimoTurno' => $ultimoTurno);
		$partidos=Partidos::model()->findAll($busqueda);

		foreach ($partidos as $partido)
		{
			$partido = new Partido($partido->id_partido);
			$partido->jugarse();
		}
	}
}
