<?php

class UsuariosController extends Controller
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
	 * Redirige al perfil del usuario
	 *
	 * @route jugadorNum12/usuarios
	 * @redirect jugadorNum12/usuarios/perfil 
	 */
	public function actionIndex()
	{
		/* TODO */
	}

	/*
	 * Mostrar los datos del personaje del usuario
	 *  Tipo del personaje
	 * 	Nivel del personaje
	 *  Aficion a la que pertenece
	 *  Habilidades pasivas desbloqueadas (y que por lo tanto estan haceindo efecto)
	 *  (...)
	 *
	 * @route jugadorNum12/usuarios/perfil
	 */
	public function actionPerfil()
	{
		/* TODO recoger los datos del usuario (se recoge de la variable de sesion)
		 * y renderizar la vista 
		 */
		/* TODO crear la vista (Nota: tendra variables)*/
	}

	/*
	 * Mostrar los datos del personaje de otro usuario: 
	 *  Tipo del personaje
	 * 	Nivel del personaje
	 *  Aficion a la que pertenece
	 *  (...)
	 *
	 * @param id del usuario a mostrar
	 * @route jugadorNum12/usuarios/ver/{$id}
	 */
	public function actionVer($id)
	{
		/* TODO */ 
		// Nota: la vista tendra variables */
	}

	/*
	 * Mostrar los datos de la cuenta del usuario
	 *  Nick
	 *  eMail
	 *
	 * @route jugadorNum12/usuarios/cuenta
	 */
	public function actionCuenta()
	{
		/* TODO */
		/* recoger los datos del usuario (se recoge de la variable de sesion)
		   y renderizar la vista 
		*/
	}

	/*
	 * Muestra un formulario para cambiar la clave
	 * Recoge datos en $_POST y procesa el formulario 
	 * Guarda la nueva <<pass>> en la tabla <<usuarios>> 
	 *
	 * @route jugadorNum12/usuarios/cambiarClave
	 * @redirect jugadorNum12/usuarios/cuenta
	 */
	public function actionCambiarClave()
	{
		/* TODO */
	}

	/*
	 * Muestra un formulario para cambiar el eMail
	 * Recoge datos en $_POST y procesa el formulario 
	 * Guarda el nuevo <<email>> en la tabla <<usuarios>> 
	 *
	 * @route jugadorNum12/usuarios/cambiarEmail
	 * @redirect jugadorNum12/usuarios/cuenta
	 */
	public function actionCambiarEmail()
	{
		/* TODO */

		// Nota: el email es unico para cada usuario
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Usuarios::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
