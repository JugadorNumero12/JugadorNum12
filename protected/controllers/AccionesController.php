<?php

/* Control para la funcionalidad relacionada con las acciones */
class AccionesController extends Controller
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
	 * Muestra todas las acciones (individuales y grupales) 
	 * desbloqueadas por el usuario.
	 * El id del usuario se recoge de la varibale de sesion
	 *
	 * Las acciones que el usuario no pueda hacer (por falta de recursos)
	 * aparecen remarcadas 
	 * 
	 * @route jugadorNum12/acciones
	 */
	public function actionIndex()
	{
		/* TODO */
	}

	/**
	 * Ejecuta la accion pulsada
	 *
	 * Si es una accion grupal implica lanzar un formulario
	 * para recoger la cantidad inicial de recursos que aporta el jugador
	 * Los datos del formulario se recogen por POST y se crea una 
	 * nueva accion grupal en el equipo al que pertenece el usuario
	 *
	 * Si es una accion individual se ejecuta
	 * 
	 * @param id de la accion
	 * @route jugadorNum12/acciones/usar/{$id_accion}
	 * @redirect jugadorNum12/equipos/ver/{$id_equipo}
	 */
	public function actionUsar($id_accion)
	{
		/* TODO */
	}

	/**
	 * Muestra la informacion relativa a una accion grupal abierta
	 *  recursos totales 
	 *  jugadores que participan en ella
	 *  recursos aportados por cada jugador
	 *  efecto si se consigue la accion
	 *  
	 * Si es el usuario que la creo, muestra ademas
	 *  botones para expulsar participantes
	 * 
	 * @param id de la accion grupal que se muestra
	 * @route jugadorNum12/acciones/ver/{$id_accion}
	 */
	public function actionVer($id_accion)
	{

	}

	/**
	 * Permite participar en una accion grupal abierta por tu aficion.
	 * Lanza el formulario que define que recursos vas a aportar a la
	 * accion que se recogen por POST 
	 *
	 * @param id de la accion en la que se va a participar
	 * @route jugadorNum12/acciones/participar/{$id}
	 * @redirect jugadorNum12/equipos/ver/{$id_equipo}
	 */
	public function actionParticipar($id_accion)
	{
		/* TODO */
	}

	/**
	 * Muestra un formulario de confirmacion para expulsar a un jugador
	 * participante en una accion grupal. Los recursos que puso el 
	 * jugador le son devueltos (comprobando limite de animo e influencias)
	 * 
	 * @param id_accion de donde se va a expulsar al jugador
	 * @param id_jugador que se va a expulsar
	 * @route jugadorNum12/acciones/expulsar/{$id_accion}/{$id_jugador}
	 * @redirect jugadorNum12/acciones/ver/{$id_accion}
	 */
	public function actionExpulsar($id_accion, $id_jugador)
	{
		/* TODO */
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AccionesGrupales::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='acciones-grupales-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
