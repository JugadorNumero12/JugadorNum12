<?php

class EquiposController extends Controller
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
	 * Muestra la informacion de un equipo
	 * 	aforo del estadio
	 *  nivel del equipo
	 *  listado de acciones grupales abiertas
	 *  (...)
	 * 
	 * Si accedes a la pagina de tu aficion
	 * 	mostrar las acciones en curso 
	 * 	mostar el listado de jugadores 
	 * Si accedes a la pagina de otra aficion
	 *	mostrar boton para abandonar el equipo
	 *
	 * @route jugadorNum12/equipos/ver/{$id}
	 * @param id_equipo a mostrar
	 */
	public function actionVer($id)
	{
		/* TODO */
		// Nota: utilizar la info de los modelos <<equipos>> <<clasificacion>> <<acciones_grupales>>
	}

	/**
	 * Muestra la clasificacion de todos los equipos
	 *
	 * @route jugadorNum12/equipos
	 */
	public function actionIndex()
	{
		/* TODO */
		// Nota: utilizar la info de los modelos <<equipos>> y <<clasificacion>>
	}

	/**
	 * Actualizar la aficion del usuario
	 * Redirige a la pagina de la nueva aficion
	 *
	 * @param id del equipo al que cambiamos
	 * @redirect jugadorNum12/equipos/ver/{$id_equipo_nuevo}
	 */
	public function actionCambiar($id_equipo_nuevo)
	{
		/* TODO */
		// Nota: recoger el parametro del equipo al que pertenece el usuario de la sesion
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Equipos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
