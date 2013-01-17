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
		// Nota: utilizar la info de los modelos <<equipos>> y <<clasificacion>>
		$modeloClasificacion = Clasificacion::model()->findAll(
			array('order'=>'posicion ASC')
		);

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
		$uid = Yii::app()->user->usIdent; // ID de usuario
		$eid = Yii::app()->user->usAfic; // ID de la afición del usuario

		// Si el equipo es el del usuario
		$miEquipo = ($eid == $id_equipo);

		// Obtenemos el equipo junto a todos sus usuarios y,
		// si hacen falta, sus acciones grupales
		$modeloEquipos = Equipos::model();
		$modeloEquipos->with('usuarios');
		if ( $miEquipo ) {
			$modeloEquipos->with('accionesGrupales');
		}

		$equipo = $modeloEquipos->findByPk($id_equipo);

		//Enviar datos a la vista
		$this->render('ver', array(
			'equipo'=>$equipo,
			'mi_equipo'=>$miEquipo
		));
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
		//Coger id de usuario y creo un helper
		$helper=new Helper();
		$id_usuario = Yii::app()->user->usIdent;

		//Coger de <<acciones_grupales>> todos los registros con id_usuario
		$acciones_grupales=AccionesGrupales::model()->findAllByAttributes(array('usuarios_id_usuario'=>$id_usuario));

		/* Recorrer todas las entradas de la tabla, buscando en <<Participaciones>>
			devolviendo todos los recursos a la gente que participo, borrando esos registros,
			para después borrar esa accion grupal de la tabla <<acciones_grupales>>*/
		foreach ($acciones_grupales as $accion_grupal)
		{
			/*Devuelvo los recursos de los participantes*/
			//Cojo de <<Participaciones>> todos los registros para devolver los recursos
			$participantes=Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $accion_grupal->id_accion_grupal));

			//Recorro todos los participantes devolviendoles sus recursos
			foreach ($participantes as $participante)
			{
				//Cojo el dinero,influencia y animo aportado por el usuario
				$dinero=$participante->dinero_aportado;
				$influencia=$participante->influencias_aportado;
				$animo=$participante->animo_aportado;

				//Utilizo el helper para ingresarle al usuario los recursos
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'dinero',$dinero);
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'animo',$animo);
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'influencia',$influencia);

				//Eliminar ese modelo
				$participante->delete();
			}

		}
		/*ATENCION las acciones en las que el participa ya se encarga el usuario que las creo de borrarlas
		sino le interesa tener ese aportacion de recursos*/
		//Una vez devuelto los recursos a la gente que participo en las acciones que creo el usuario
		//Cambio el id del equipo al que pertenece
		//Y guardo el modelo modificado
		$modeloUsuario = Usuarios::model()->findByPk($id);
		$modeloUsuario->setAttributes(array('equipos_id_equipo'=>$id_nuevo_equipo));
		$modeloUsuario->save();	
		$this->redirect(array('equipos/ver/','id_equipo'=>$id_nuevo_equipo));
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