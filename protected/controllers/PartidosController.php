<?php

/* pagina con la informacion de las jornadas y previas a los partidos */
class PartidosController extends Controller
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
			array('allow', // Permite realizar a los usuarios autenticados cualquier acción
				'users'=>array('@'),
			),
			array('deny',  // Niega acceso al resto de usuarios
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Muestra los partidos de la jornada que se esta jugando
	 */
	public function actionIndex()
	{
		/* TODO */
	}

	/** 
	 * Muestra la informacion previa a un partido
	 * 	fecha y hora	
	 *  ambiente para el partido
	 * 	equipo local y visitante
	 * 	detalles de ambos equipos (aforo previsto, nivel de los equipos)
	 *  acciones completadas por las aficiones
	 *
	 * @param id_partido sobre el que se consulta la previa
	 * @route jugadorNum12/partidos/previa/{$id_partido}
	 */
	public function actionPrevia($id_partido)
	{
		/* TODO */
	}

	/**
	 * Si el partido ya se jugo, mostrar la cronica (resultado)
	 * de ese partido
	 * Si el partido no se ha jugado, y es el proximo partido del
	 * equipo del jugador, mostrar la pantalla de juego de partido
	 * 
	 * @param $id_partido sobre el que se pide informacion
	 * @route jugadorNum12/partidos/asistir/{$id_partido}
	 */
	public function actionAsistir($id_partido)
	{
		/* TODO */
		// Nota: dejar en blanco (o con un simple mensaje indicativo)
		// la pantalla de jugar partido
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Partidos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='partidos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
