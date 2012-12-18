<?php

/* Control para la funcionalidad relacionada con las acciones */
class AccionesController extends Controller
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
	 * Muestra todas las acciones (individuales y grupales) desbloqueadas
	 * Las acciones que el usuario no pueda hacer (por falta de recursos)
	 * aparecen remarcadas 
	 * 
	 * El id del usuario se recoge de la varibale de sesion
	 * 
	 * @ruta jugadorNum12/acciones
	 */
	public function actionIndex()
	{
		/* PEDRO */
		//Coger datos. Todavía no puedo hacerlo porque necesito el relations() del modelo Desbloqueadas.
		//$listaHabilidades = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Mostrar la vista
		$this->render('index',array('listaHabilidades'=>$listaHabilidades));
	}

	/**
	 * Ejecuta la accion (individual o grupal) pulsada 
	 *
	 * Si es una accion grupal muestra un formulario para recoger la 
	 * cantidad inicial de recursos que aporta el jugador
	 * Los datos del formulario se recogen por $_POST y se crea una 
	 * nueva accion grupal en el equipo al que pertenece el usuario
	 * Si es una accion individual se ejecuta
	 * 
	 * El id del jugador y la aficion a la que pertence se recogen de 
	 * la variable de sesion
	 *
	 * @parametro 	id de la accion que se ejecuta
	 * @ruta 		jugadorNum12/acciones/usar/{$id_accion}
	 * @redirige 	jugadorNum12/equipos/ver/{$id_equipo} 	si es accion grupal
	 * @redirige	jugadorNum12/usuarios/perfil 			si es accion individual
	 */
	public function actionUsar($id_accion)
	{
		/* DANI */
	}

	/**
	 * Muestra la informacion relativa a una accion grupal abierta
	 *  recursos totales requeridos en la accion
	 *  jugadores que participan en ella
	 *  recursos aportados por cada jugador
	 *  efecto si se consigue la accion
	 *  
	 * Si es el usuario que la creo, muestra ademas
	 *  botones para expulsar participantes
	 * 
	 * @parametro 	id de la accion grupal que se muestra
	 * @ruta 		jugadorNum12/acciones/ver/{$id_accion}
	 */
	public function actionVer($id_accion)
	{
		/* PEDRO */
	}

	/**
	 * Permite participar en una accion grupal abierta por tu aficion.
	 * Muestra el formulario que define que recursos va a aportar a la
	 * accion que se recogen por $_POST 
	 *
	 * El id del jugador se recoge de la variable de sesion
	 *
	 * @parametro 	id de la accion en la que se va a participar
	 * @ruta 		jugadorNum12/acciones/participar/{$id}
	 * @redirige 	jugadorNum12/equipos/ver/{$id_equipo}
	 */
	public function actionParticipar($id_accion)
	{
		/* PEDRO */
	}

	/**
	 * Muestra un formulario de confirmacion para expulsar a un jugador
	 * participante en una accion grupal.
	 * Los recursos que puso el jugador le son devueltos
	 * (comprobando limite de animo e influencias)
	 * 
	 * @parametro 	id_accion de donde se va a expulsar al jugador
	 * @parametro 	id_jugador que se va a expulsar
	 * @ruta 		jugadorNum12/acciones/expulsar/{$id_accion}/{$id_jugador}
	 * @redirige 	jugadorNum12/acciones/ver/{$id_accion}
	 */
	public function actionExpulsar($id_accion, $id_jugador)
	{
		/* MARCOS */
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
