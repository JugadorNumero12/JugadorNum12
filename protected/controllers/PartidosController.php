<?php

/* pagina con la informacion de las jornadas y previas a los partidos */
class PartidosController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Muestra los partidos de la jornada que se esta jugando
	 *
	 * @ruta 	jugadorNum12/partidos
	 */
	public function actionIndex()
	{
		/* ARTURO */
	}

	/** 
	 * Muestra la informacion previa a un partido
	 * 	fecha y hora	
	 *  ambiente para el partido
	 * 	equipo local y visitante
	 * 	detalles de ambos equipos (aforo previsto, nivel de los equipos)
	 *  acciones completadas por las aficiones
	 *
	 * @parametro 	id del partido sobre el que se consulta la previa
	 * @ruta 		jugadorNum12/partidos/previa/{$id_partido}
	 */
	public function actionPrevia($id_partido)
	{
		/* MARINA */
	}

	/**
	 * Muestra la pantalla para "jugar" un partido
	 * Si el partido ya se jugo, mostrar la cronica (resultado) de ese partido
	 * Si el partido no se ha jugado, y es el proximo partido del
	 * equipo del jugador, mostrar la pantalla de juego de partido
	 * 
	 * @parametro 	$id_partido sobre el que se pide informacion
	 * @ruta 		jugadorNum12/partidos/asistir/{$id_partido}
	 */
	public function actionAsistir($id_partido)
	{
		/* ARTURO */
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
