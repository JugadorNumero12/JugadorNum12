<?php

/* Pagina del "arbol" de habilidades */
class HabilidadesController extends Controller
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
	 * Muestra el arbol de habilidades completo del juego
	 *
	 * @route jugadorNum12/habilidades
	 */
	public function actionIndex()
	{
		/* TODO */
	}

	/**
	 * Muestra la informacion de la habilidad seleccionada
	 *  nombre
	 *  descripcion (efecto, coste, detalles, ...)
	 *  requisitos para desbloquear 
	 * 
	 * Si la accion ya esta desbloqueada por el usuario, indicarlo
	 * Si no esta aun disponible mostrar un boton para escogerla
	 *
	 * @param id_habilidad sobre la que mostramos la informacion
	 * @route jugadorNum12/habilidades/{$id_habilidad}
	 */
	public function actionVer($id_habilidad)
	{
		/* TODO */
	}

	/**
	 * Lanza un formulario de confirmacion para adquirir la habilidad
	 * y que pase al listado de habilidades desbloqueadas
	 *
	 * @param id_habilidad que se va a adquirir
	 * @redirect jugadorNum12/acciones si la habilidad es una accion
	 * @redirect jugadorNum12/usuarios/perfil si la habilidad es pasiva
	 */
	public function actionAdquirir($id_habilidad)
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
		$model=Habilidades::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='habilidades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
