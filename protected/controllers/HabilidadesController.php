<?php

/**
 * Controlador de las habilidades
 *
 *
 * @package controladores
 */
class HabilidadesController extends Controller
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
	 * Muestra el arbol de habilidades completo 
	 *
	 * @route  jugadorNum12/habilidades
	 * @return void
	 */
	public function actionIndex()
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Sacar una lista de las acciones desbloqueadas de un usuario
		//$accionesDesbloqueadas = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Sacar una lista con los recursos del usuario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Sacar el nivel del usuario
		$usuario = Usuarios::model()->findByPK(Yii::app()->user->usIdent);

		$accionesGrupales = AccionesGrupales::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));
		$accionesIndividuales = AccionesIndividuales::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Comprobaciones de seguridad
		/*if (($accionesDesbloqueadas === null) || ($recursosUsuario === null)) {
			Yii::app()->user->setFlash('error', 'Acciones o recursos no encontrados. (actionIndex, AccionesController).');
		} */
			
		//A partir de las acciones sacamos las habilidades para poder mostrarlas
		/* $acciones = array();
		foreach ($accionesDesbloqueadas as $habilidad)
		{
			$hab = Habilidades::model()->findByPK($habilidad['habilidades_id_habilidad']);

			//Comprobación de seguridad
			if ($hab === null) {
				Yii::app()->user->setFlash('habilidad', 'Habilidad no encontrada. (actionIndex,AccionesController).');
			}	
				
			$acciones[] = $hab;
		} */

		$acciones = Habilidades::model()->findAll();

		//Envía los datos para que los muestre la vista
		$this->render('index', array('acciones'=>$acciones, 'recursosUsuario'=>$recursosUsuario, 'usuario'=>$usuario, 'accionesGrupales'=>$accionesGrupales, 'accionesIndividuales'=>$accionesIndividuales));
	}


	/**
	 * Muestra la informacion de la habilidad seleccionada
	 *  
	 * - Nombre de la habilidad
	 * - Descripción de la habilidad 
	 * - Coste en recursos
	 * - Requisitos necesarios para desbloquear la habilidad
	 * 
	 * @param int $id_habilidad	id de la habilidad seleccionada
	 * @route jugadorNum12/habilidades/{$id_habilidad}
     * @return void
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
		}

		$desb = false;
		foreach ($habilidad['desbloqueadas'] as $id => $d) {
			if ( $d['usuarios_id_usuario'] == $idUsuario) {
				$desb = true;
			}
		}



		//$habilidades = Habilidades::model()->with('desbloqueadas')->findAll();

		$codigoRequisitos = array();

		//saco los requisitos de la habilidad para ser desbloqueada (nivel, y habilidades previas desbloqueadas)	
		$codigoRequisitos = RequisitosDesbloquearHabilidades::$datos_acciones[$habilidad->codigo]['desbloqueadas_previas'];
		$nivel = RequisitosDesbloquearHabilidades::$datos_acciones[$habilidad->codigo]['nivel'];

		$requisitos = array();
		foreach($codigoRequisitos as $h){
			$nombre = Habilidades::model()->findByAttributes(array('codigo'=>$h));
			$requisitos[] = $nombre['nombre'];
		}

		// Prepara los datos a enviar a la vista
		$datosVista = array(
			'habilidad' => $habilidad,
			'desbloqueada' => $desb,
			'nivel' => $nivel,
			'requisitos' => $requisitos
		);

		// Obtiene una lista con todas las habilidades
		

		// Cargar css de ver habilidad
		//$uri = Yii::app()->request->baseUrl.'/less/infohabilidad.less';
		//Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);
			
		// Manda pintar la habilidad en la vista
		$this->render('ver', $datosVista);
	}

	/**
	 * Muestra un formulario de confirmacion para adquirir una habilidad
	 * 
	 * > Si hay datos en $_POST procesa el formulario y registra la habilidad como desbloqueada
	 *
	 * @param int $id_habilidad	id de la habilidad que se va a adquirir
     * 
     * @route jugadorNum12/habilidades/adquirir/{$id_habilidad}
	 * @redirect jugadorNum12/acciones si la habilidad es una accion
	 * @redirect jugadorNum12/usuarios/perfil si la habilidad es pasiva
     *
     * @throws \Exception Fallo al guardar la nueva habilidad en la BD
     * @return void
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
		$desbloqueada = Desbloqueadas::model()->findByAttributes(array(
            'usuarios_id_usuario' => Yii::app()->user->usIdent,
		    'habilidades_id_habilidad' => $id_habilidad
		));

		//realizar transaccion con la base de datos
		if($habilidad === null){
			//si la habilidad que quieres desbloquear existe como tal
			$trans->rollback();
			Yii::app()->user->setFlash('habilidad', 'Habilidad inexistente.');
		}

		if ( $desbloqueada != null){
			//si esta desbloqueada 
			$trans->rollback();
			Yii::app()->user->setFlash('desbloqueada', 'La habilidad ya ha sido desbloqueada.');
			$this-> redirect(array('habilidades/index'));
		} else {
			// comprobamos que pueda desbloquedar la habilidad. Nivel necesario, hab necesarias desbloqueadas etc
			if( $habilidad->puedeDesbloquear(Yii::app()->user->usIdent,$id_habilidad)){

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

	        			//Al desbloquear la habilidad se gasta un punto de desbloqueo
	        			$usuario = Usuarios::model()->findByPk(Yii::app()->user->usIdent);
	        			$usuario->puntos_desbloqueo -= 1;
	        			$usuario->save();

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
	        			$this->redirect(array('habilidades/'));       			
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

	        } else{ //el ususario, no puede desbloquear la habilidad
	        	Yii::app()->user->setFlash('desbloqueada', 'No cumples los requisitos para desbloquear la habilidad.');
	        	$this->redirect(array('habilidades/index'));	
	        }
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
		$model=Habilidades::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='habilidades-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
