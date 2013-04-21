<?php

/**
 * Controlador de los equipos
 *
 *
 * @package controladores
 */
class EquiposController extends Controller
{
    /**
    * Definicion del verbo DELETE unicamente via POST
    *
    * > Funcion predeterminada de Yii
    *
    * @return string[]     filtros definidos para "actions"
    */
    public function filters()
    {
        return array('accessControl', 'postOnly + delete');
    }

    /**
     * Especifica las reglas de control de acceso.
     * 
     *  - Permite realizar a los usuarios autenticados cualquier accion
     *  - Niega el acceso al resto de usuarios
     *
     * > Funcion predeterminada de Yii 
     *
     * @return object[]     reglas usadas por el filtro "accessControl"
     */
	public function accessRules()
	{
		return array(
			array('allow', 'users'=>array('@')),
			array('deny', 'users'=>array('*')),
		);
	}

    /**
     * Muestra la clasificacion de todos los equipos
     *
     * @route jugadorNum12/equipos
     * @return void
     */
	public function actionIndex()
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		$modeloClasificacion = Clasificacion::model()->findAll(array('order'=>'posicion ASC'));
		if ($modeloClasificacion === null) {
			Yii::app()->user->setFlash('clasificacion', 'Clasificacion incorrecta. (actionIndex, EquiposController).');
		}

		$this->render('index',array('modeloC'=>$modeloClasificacion));
	}

    /**
     * Muestra la informacion de un equipo
     *
     * - nombre (color) del equipo
     * - aforo maximo del estadio
     * - aforo basico del estadio
     * - nivel del equipo
     * - numero de jugadores en esa aficion
     * 
     * Si se accede a la pagina de tu aficion mostrar ademas:
     * 	 
     * - acciones grupales abiertas 
     * - listado de jugadores
     *  
     * Si se accede a la pagina de otra aficion mostrar:
     *
     * - boton para cambiarse a esa aficion
     * 
     * > El id del jugador se recoge de la variable de sesion*
     *
     * @param   int $id_equipo 	id del equipo a mostrar
     *
     * @route   jugadorNum12/equipos/ver/{$id_equipo}
     * @return  void
     */
	public function actionVer($id_equipo)
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */

		$uid = Yii::app()->user->usIdent; // ID de usuario
		$eid = Yii::app()->user->usAfic; // ID de la afición del usuario

		// Si el equipo es el del usuario
		$miEquipo = ($eid == $id_equipo);

		// Obtenemos el equipo junto a todos sus usuarios y,
		// si hacen falta, sus acciones grupales
		$modeloEquipo = Equipos::model()->with('usuarios');
		if ( $miEquipo ) {
			$modeloEquipo->with('accionesGrupales');
		}

		$equipo = $modeloEquipo->findByPK($id_equipo);

		if ( $equipo === null ) {
			Yii::app()->user->setFlash('equipo', 'Equipo inexistente.');
		}

		//Enviar datos a la vista
		$this->render('ver', array('equipo'=>$equipo,'mi_equipo'=>$miEquipo));
	}

	/**
	 * Cambiar la aficion a la que pertenece un usuario
	 *
	 * Actualiza la tabla <usuarios> y <equipos>
     *
     * Las acciones grupales en las que participaba el usuario en el equipo original se 
     * quedan intactas; el creador de la accion podra si quiere, eliminar esas aportaciones
	 * 
	 * > El id del jugador y el equipo al que pertence se recogen de la variable de sesion
	 *
	 * @param int $id_nuevo_equipo     id del nuevo equipo al que cambia el jugador
     *
     * @route       jugadorNum12/equipos/cambiar/{$id_nuevo_equipo}
	 * @redirect 	jugadorNum12/equipos/ver/{$id_equipo_nuevo}
     * @return      void
	 */
	public function actionCambiar($id_nuevo_equipo)
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Coger id de usuario
		$id_usuario = Yii::app()->user->usIdent;
		$modeloUsuario=Usuarios::model()->findByPk($id_usuario);
		$modeloEquipo=Equipos::model()->findByPk($id_nuevo_equipo);

		//Si el id del nuevo equipo corresponde con el mismo en el que estaba error
		//Si el id nuevo no corresponde a ningun equipo tambien devuelve error
		if($id_nuevo_equipo == $modeloUsuario->equipos_id_equipo) {
			Yii::app()->user->setFlash('equipo_actual', 'Tienes que cambiarte a un equipo diferente al actual.');
			$this->redirect(array('equipos/ver/','id_equipo'=>$id_nuevo_equipo));
		}
		else if ($modeloEquipo===null) {
			Yii::app()->user->setFlash('equipo', 'No existe el equipo al que quiere cambiarse.');
		} else {
			//Coger de <<acciones_grupales>> todos los registros con id_usuario
			$acciones_grupales=AccionesGrupales::model()->findAllByAttributes(array('usuarios_id_usuario'=>$id_usuario));

			foreach ($acciones_grupales as $accion_grupal)
			{
				AccionesGrupales::finalizaGrupal($accion_grupal->id_accion_grupal, true);
			}
			/*ATENCION las acciones en las que el participa ya se encarga el usuario que las creo de borrarlas
			sino le interesa tener ese aportacion de recursos*/
			
			//Una vez devueltos los recursos a la gente que participo en las acciones que creo el usuario
			//cambio el id del equipo al que pertenece y guardo el modelo modificado
			$modeloUsuario = Usuarios::model()->findByPk($id_usuario);
			$modeloUsuario->setAttributes(array('equipos_id_equipo'=>$id_nuevo_equipo));
			$modeloUsuario->save();	

			//Cambiar variable de sesion
			Yii::app()->user->setState('usAfic', $id_nuevo_equipo);
			$this->redirect(array('equipos/ver/','id_equipo'=>$id_nuevo_equipo));
		}
	}

    /**
     * Devuelve el modelo de datos basado en la clave primaria dada por la variable GET 
     *
     * > Funcion predeterminada de Yii
     * 
     * @param int $id            id del modelo que se va a cargar 
     * @throws \CHttpException   El modelo de datos no se encuentra 
     * @return \AccionesGrupales modelo de datos
     */
	public function loadModel($id)
	{
		$model=Equipos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    /**
     * Realiza la validacion por Ajax 
     *
     * > Funcion predeterminada de Yii
     * 
     * @param $model (CModel) modelo a ser validado
     * @return void
     */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipos-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
}
