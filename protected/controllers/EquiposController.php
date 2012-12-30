<?php

/* Pagina de equipos o aficiones */
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
	 * Muestra la clasificacion de todos los equipos
	 *
	 * @ruta jugadorNum12/equipos
	 */
	public function actionIndex()
	{
		/* MARINA */
		// Nota: utilizar la info de los modelos <<equipos>> y <<clasificacion>>
		$modeloClasificacion = Clasificacion:: model()->findAll();

		$this->render('index',array('modeloC'=>$modeloClasificacion));
	}

	/**
	 * Muestra la informacion de un equipo
	 *	 nombre (color) del equipo (aficion)
	 * 	 aforo maximo del estadio
	 *	 aforo basico del estadio
	 *   nivel del equipo
	 *   numero de jugadores en esa aficion
	 * 
	 * Si se accede a la pagina de tu aficion mostrar ademas:
	 * 	 acciones grupales abiertas 
	 * 	 listado de jugadores
	 * El id del jugador se recoge de la variable de sesion
	 *  
	 * Si se accede a la pagina de otra aficion mostrar:
	 *	 boton para cambiarse a esa aficion
	 *
	 * @ruta 		jugadorNum12/equipos/ver/{$id}
	 * @parametro 	id del equipo a mostrar
	 */
	public function actionVer($id_equipo)
	{
		/* SAM */
		// Nota: utilizar la info de los modelos <<equipos>> <<clasificacion>> <<acciones_grupales>>
		// Nota: en comentarios "aficion" y "equipo" son sinonimos
	}

	/**
	 * Cambiar la aficion a la que pertenece un usuario
	 * Actualiza la tabla <<usuario>> y <<equipos>>
	 * 
	 * El id del jugador y el equipo al que pertence se recogen 
	 * de la variable de sesion
	 *
	 * @parametro 	id del nuevo equipo al que cambia el jugador
	 * @redirige 	jugadorNum12/equipos/ver/{$id_equipo_nuevo}
	 */
	public function actionCambiar($id_nuevo_equipo)
	{
		/* SAM */
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
