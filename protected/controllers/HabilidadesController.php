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
	 * Muestra el arbol de habilidades completo 
	 *
	 * @ruta 	jugadorNum12/habilidades
	 */
	public function actionIndex()
	{
		// Obtiene una lista con todas las habilidades
		$habilidades = Habilidades::model()->findAll();

		// Prepara los datos a enviar a la vista
		$datosVista = array(
			'habilidades' => $habilidades
		);

		// Manda pintar la lista a la vista
		$this->render('index', $datosVista);
	}

	/**
	 * Muestra la informacion de la habilidad seleccionada
	 *  nombre
	 *  descripcion (efecto, coste, detalles, ...)
	 *  requisitos para desbloquear 
	 * 
	 * el id del usuario se recoge de la variable de sesion
	 * Si la accion ya esta desbloqueada por el usuario, indicarlo
	 * Si no esta aun disponible mostrar un boton para escogerla
	 *
	 * @parametro 	id de la habilidad seleccionada
	 * @ruta 		jugadorNum12/habilidades/{$id_habilidad}
	 */
	public function actionVer($id_habilidad)
	{
		// Obtiene la acción a consultar
		$habilidad = Habilidades::model()->findByPk($id_habilidad);

		// Prepara los datos a enviar a la vista
		$datosVista = array(
			'habilidad' => $habilidad
		);

		// Manda pintar la habilidad en la vista
		$this->render('ver', $datosVista);
	}

	/**
	 * Muestra un formulario de confirmacion para adquirir una habilidad
	 * 
	 * Si hay datos en $_POST procesa el formulario y registra 
	 * la habilidad como desbloqueada
	 *
	 * @parametro 	id de la habilidad que se va a adquirir
	 * @redirige 	jugadorNum12/acciones si la habilidad es una accion
	 * @redirige 	jugadorNum12/usuarios/perfil si la habilidad es pasiva
	 */
	public function actionAdquirir($id_habilidad)
	{
		/* ARTURO */
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
