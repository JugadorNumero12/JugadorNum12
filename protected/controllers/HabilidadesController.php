<?php

/* Pagina del "arbol" de habilidades */
class HabilidadesController extends Controller
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
