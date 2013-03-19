
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		$idUsuario = Yii::app()->user->usIdent;

		// Obtiene una lista con todas las habilidades
		$habilidades = Habilidades::model()->with('desbloqueadas')->findAll();

		// FIXME: Hacerlo mínimamente eficiente -- esto es O(N²)
		$desbloqueadas = array();
		foreach ($habilidades as $ih => $h) {
			$desb = false;

			foreach ($h['desbloqueadas'] as $id => $d) {
				if ( $d['usuarios_id_usuario'] == $idUsuario) {
					$desb = true;
				}
			}

			$desbloqueadas[$ih] = $desb;
		}

		// Prepara los datos a enviar a la vista
		$datosVista = array(
			'habilidades' => $habilidades,
			'desbloqueadas' => $desbloqueadas
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		// Obtiene la acción a consultar
		$idUsuario = Yii::app()->user->usIdent;
		$habilidad = Habilidades::model()->with('desbloqueadas')->findByPk($id_habilidad);

		if ($habilidad === null) {
			Yii::app()->user->setFlash('habilidad', 'Habilidad inexistente.');
			//throw new CHttpException( 404, 'Habilidad inexistente');
		}

		$desb = false;
		foreach ($habilidad['desbloqueadas'] as $id => $d) {
			if ( $d['usuarios_id_usuario'] == $idUsuario) {
				$desb = true;
			}
		}

		// Prepara los datos a enviar a la vista
		$datosVista = array(
			'habilidad' => $habilidad,
			'desbloqueada' => $desb
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//empezamos la transaccion
		$trans = Yii::app()->db->beginTransaction();

		//obtenemos la habilidad para pasarsela a la vista
		$habilidad = Habilidades::model()->findByPk($id_habilidad);

		//vemos si una habilidad esta desbloqueada para el usuario
		$desbloqueada = Desbloqueadas::model()->findByAttributes(array('usuarios_id_usuario' => Yii::app()->user->usIdent,
																	   'habilidades_id_habilidad' => $id_habilidad
																	  ));

		//realizar transaccion con la base de datos
		if($habilidad === null){
			//si la habilidad que quieres desbloquear existe como tal
			$trans->rollback();
			Yii::app()->user->setFlash('habilidad', 'Habilidad inexistente.');
			//throw new CHttpException(404,'La habilidad no existe.');
		}

		if ( $desbloqueada != null){
			//si esta desbloqueada 
			$trans->rollback();
			Yii::app()->user->setFlash('desbloqueada', 'La habilidad ya ha sido desbloqueada.');
			$this-> redirect(array('habilidades/index'));

		} else {
			//si no esta desbloqueada y existe
			//si el usuario acepta guardamos el id de la habilidad y el id de usuario en Desbloqueadas
			if(isset($_POST['aceptarBtn']))
			{
        		try
        		{        			
        			$desbloqueada = new Desbloqueadas();
        			$desbloqueada['habilidades_id_habilidad'] = $id_habilidad ;
        			$desbloqueada['usuarios_id_usuario'] = Yii::app()->user->usIdent;
        			$desbloqueada->save();

        			//Si es pasiva, debemos aplicar el beneficio de la misma
        			if ($habilidad->tipo == Habilidades::TIPO_PASIVA)
        			{		        		  		
						Yii::import('application.components.Acciones.*');

						//Tomar nombre de habilidad
		        		$nombreHabilidad = $habilidad->codigo;

		        		//Llamar al singleton correspondiente y ejecutar dicha acción
		        		$nombreHabilidad::getInstance()->ejecutar(Yii::app()->user->usIdent);
        			}

        			$trans->commit(); 
        			$this->redirect(array('acciones/'));       			
        		} 
        		catch ( Exception $exc ) 
        		{
					$trans->rollback();
					throw $exc;
				}
        		
        	}       
        	//si el usuario cancela, rollback 	
      		if(isset($_POST['cancelarBtn'])){
        		$trans->rollback();
        		$this->redirect(array('habilidades/index'));
        	}

        	//pasar la habilidad a la vista para mostrar que habilidad se esta desboqueando
        	$this->render('adquirir', array('habilidad'=>$habilidad));
		}
		
/* MASTER 
			Yii::app()->user->setFlash('desbloqueada', 'La habilidad ya ha sido desbloqueada.');
			$this-> redirect(array('habilidades/index'));
		} 

		//si no esta desbloqueada y existe
		//si el usuario acepta guardamos el id de la habilidad y el id de usuario en Desbloqueadas
		if(isset($_POST['aceptarBtn'])){
    		try{        			
    			$desbloqueada = new Desbloqueadas();
    			$desbloqueada['habilidades_id_habilidad'] = $id_habilidad ;
    			$desbloqueada['usuarios_id_usuario'] = Yii::app()->user->usIdent;
    			$desbloqueada->save();
    			$trans->commit(); 
    			$this->redirect(array('habilidades/index'));       			
    		} catch ( Exception $exc ) {
				$trans->rollback();
				throw $exc;
			}
    		
    	}       
    	//si el usuario cancela, rollback 	
  		if(isset($_POST['cancelarBtn'])){
    		$trans->rollback();
    		$this->redirect(array('habilidades/index'));
    	}

    	//pasar la habilidad a la vista para mostrar que habilidad se esta desboqueando
    	$this->render('adquirir', array('habilidad'=>$habilidad));		
>>>>>>> master*/
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
