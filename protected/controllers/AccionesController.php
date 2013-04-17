<?php

/** 
 * Controlador de las acciones 
 *
 *
 * @package controladores
 */
class AccionesController extends Controller
{
    /**
     * Definicion del verbo DELETE unicamente via POST
     *
     * > Funcion predeterminada de Yii
     *
     * @return string[] 	filtros definidos para "actions"
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
     * @return object[] 	reglas usadas por el filtro "accessControl"
     */
	public function accessRules()
	{
		return array(
			array('allow', 'users'=>array('@')),
			array('deny',  'users'=>array('*')),
		);
	}

	/**
	 * Muestra todas las acciones (individuales y grupales) desbloqueadas
	 * 
	 * Las acciones que el usuario no pueda hacer (por falta de recursos)
	 * aparecen remarcadas 
	 * 
	 * > El id del usuario se recoge de la varibale de sesion
	 * 
	 * @route jugadorNum12/acciones
	 * @return void
	 */
	public function actionIndex()
	{

		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Sacar una lista de las acciones desbloqueadas de un usuario
		$accionesDesbloqueadas = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Sacar una lista con los recursos del usuario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Comprobaciones de seguridad
		if (($accionesDesbloqueadas === null) || ($recursosUsuario === null)) {
			Yii::app()->user->setFlash('error', 'Acciones o recursos no encontrados. (actionIndex, AccionesController).');
		}
		
		//A partir de las acciones sacamos las habilidades para poder mostrarlas
		$acciones = array();
		foreach ($accionesDesbloqueadas as $habilidad) {
			$hab = Habilidades::model()->findByPK($habilidad['habilidades_id_habilidad']);

			//Comprobación de seguridad
			if ($hab === null)
				Yii::app()->user->setFlash('hamilidad', 'Habilidad no encontrada. (actionIndex,AccionesController).');
			$acciones[] = $hab;
		}

		//Envía los datos para que los muestre la vista
		$this->render('index',array('acciones'=>$acciones, 'recursosUsuario'=>$recursosUsuario));

	}

	/**
	 * Ejecuta la accion (individual o grupal) pulsada. Significa bajarse la carta de habilidad 
	 *
	 * Cualquier habilidad resta los recursos iniciales al jugador, además,
	 *
	 * - Si es una accion grupal muestra un formulario para recoger la cantidad inicial de recursos
	 * que aporta el jugador (podría no aportar recursos).
	 * Los datos del formulario se recogen por $_POST y se crea una nueva accion grupal en el equipo
	 * al que pertenece el usuario
	 * 
	 * - Si es una accion individual se ejecuta al momento
	 * 
	 * > El id del jugador y la aficion a la que pertence se recogen de la variable de sesion
	 *
	 * > No se le pasaran acciones individuales ni de partido
	 *
	 * @param int $id_accion 	id de la accion que se ejecuta
	 * 
	 * @route jugadorNum12/acciones/usar/{$id_accion}
	 * @redirect jugadorNum12/equipos/ver/{$id_equipo} 	si es accion grupal
	 * @redirect jugadorNum12/usuarios/perfil 			si es accion individual
	 *
	 * @return void
	 */
	public function actionUsar($id_accion)
	{	
		// TODO : pasar la logica al modelo 

		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Comenzar transaccion
		$trans = Yii::app()->db->beginTransaction();

		try {
			// Importar acciones
			Yii::import('application.components.Acciones.*');

			//Cojo el id_usuario
			$id_usuario=Yii::app()->user->usIdent;

			//Obtener modelo de Habilidades
			$habilidad = Habilidades::model()->findByPk($id_accion);

			//Habilidad no encontrada
			if ( $habilidad === null ) {			
				$trans->rollback();
				Yii::app()->user->setFlash('inexistente', 'Acción inexistente.');
				$this-> redirect(array('acciones/index'));
			}

			//Habilidad encontrada
			//Obtener modelo de Desbloqueadas		
			$desbloqueada = Desbloqueadas::model()->findByAttributes(array('usuarios_id_usuario' => $id_usuario,
																	   	   'habilidades_id_habilidad' => $id_accion ));			
			//Si no esta desbloqueada para el usuario, error
			if( $desbloqueada === null) {				
				$trans->rollback();
				Yii::app()->user->setFlash('bloqueada', 'No tienes desbloqueada la acción.');
				$this-> redirect(array('acciones/index'));
			} 
			
			//Si esta desbloqueada
			//Obtener modelo de Recursos
			$res = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_usuario));
			
			//Si no son suficientes recursos cancelar transaccion y notificar al usuario
			if ( $res['dinero'] 	 < $habilidad['dinero'] ||
			     $res['animo'] 		 < $habilidad['animo']  ||
			     $res['influencias'] < $habilidad['influencias'])
			{			
				$trans->rollback();
				Yii::app()->user->setFlash('recursos', 'No tienes suficientes recursos.');
				$this-> redirect(array('acciones/index'));
			}

			$usuario = Usuarios::model()->findByPk($id_usuario);

			//Si tenemos suficientes recursos miramos si es individual o grupal
			if ( $habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL ) { 								   
				AccionesIndividuales::usarIndividual($id_usuario, $id_accion, $res, $habilidad);
			} else if ( $habilidad['tipo'] == Habilidades::TIPO_GRUPAL ) {
				//Sacar la accion grupal
				//$accion_grupal = AccionesGrupales::model()->findByPk($id_accion);
				$id_usuario=Yii::app()->user->usIdent;
				$id_equipo=Yii::app()->user->usAfic;
				$accion_grupal = AccionesGrupales::model()->findByAttributes(array('equipos_id_equipo' => $id_equipo,
				  															       'habilidades_id_habilidad' => $id_accion,
				  															       'usuarios_id_usuario' =>  $id_usuario,
				  															        ));
				//Si no esta creada
				if($accion_grupal === null) {
					$nuevo_id = AccionesGrupales::usarGrupal($usuario, $id_accion, $id_equipo, $res, $habilidad);			
				} else {
					//Si esta creada 
					//sacar el id de accion grupal (pk) y redirigir a participar($id_accion_grupal)
					$this-> redirect(array('acciones/participar',
										   'id_accion'=>$accion_grupal['id_accion_grupal'] ));
				}
			} else if($habilidad['tipo'] == Habilidades::TIPO_PARTIDO ) {
				//Sacar id de usuario,equipo y partido para poder ejecutar la accion del partido				
				$id_usuario=Yii::app()->user->usIdent;
				$id_equipo=Yii::app()->user->usAfic;
				$equipo=Equipos::model()->findByAttributes(array('id_equipo' => $id_equipo)); 

				if($equipo === null) {
					//Mostrar mensaje flash de error 
				}
				$siguientepartido=$equipo->sigPartido;
				$id_partido=$siguientepartido->id_partido;
				AccionesTurno::usarPartido($id_usuario,$id_equipo,$id_partido,$habilidad,$res);

			} else { 
				// Tipo inválido
				$trans->rollback();
				Yii::app()->user->setFlash('error', 'No puedes usar esa acción.');
				$this-> redirect(array('acciones/index'));
			}

			// Finalizar transacción
			$trans->commit();

			//Renderizar acción individual 
			if ( $habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL ) { 
				/* 	como no está definido el id_accion_grupal, le damos cualquier valor
					porque en la vista no se usa si es de tipo individual, pero necesita ser != null */
				$id_acc = -1;
				$this->render('usar', array('id_acc'=>$id_acc,'habilidad'=>$habilidad, 'res'=>$res));
			} else {
				//Renderizar acción grupal
				$this->render('usar', array('id_acc'=>$nuevo_id,'habilidad'=>$habilidad, 'res'=>$res));
			}
		} catch (Exception $e) {
			$this-> redirect(array('acciones/index'));
		}
	}

	/**
	 * Muestra la informacion relativa a una accion grupal abierta.
	 *
	 *  - recursos totales requeridos en la accion
	 *  - jugadores que participan en ella
	 *  - recursos aportados por cada jugador
	 *  - efecto si se consigue la accion
	 *  
	 * Si es el usuario que la creo, muestra ademas
	 * 
	 * - botones para expulsar participantes
	 * 
	 * @param int $id_accion 	id de la accion grupal que se muestra
	 * @route jugadorNum12/acciones/ver/{$id_accion}
	 * @return void
	 */
	public function actionVer($id_accion)
	{
		// TODO: pasar logica al modelo

		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		// Cojo la acción de la tabla acciones_grupales
		$accionGrupal = AccionesGrupales::model()
			->with('habilidades')
			->with('participaciones')
			->with('usuarios')
			->findByPk($id_accion);

		//Comprobación de seguridad
		if ($accionGrupal === null)
			Yii::app()->user->setFlash('grupal', 'La acción grupal no existe.');
			//throw new CHttpException(404,"La acción grupal no existe.");
			
		// Saco el usuario
		$usuario = Yii::app()->user->usIdent;
		$equipoUsuario = Yii::app()->user->usAfic;

		// Si el usuario no es del equipo de la acción, no tenemos permiso
		if ( $accionGrupal['equipos_id_equipo'] != $equipoUsuario ) {
			Yii::app()->user->setFlash('otro_equipo', 'La acción no es de tu equipo.');
			$this-> redirect(array('acciones/index'));
		}

		// Saco el propietario de la acción
		$propietarioAccion = $accionGrupal['usuarios_id_usuario'];

		// Saco el equipo que ha creado la accion
		$equipoAccion = $accionGrupal['equipos_id_equipo'];
 
		// Compruebo si el usuario ha participado ya en la accion
		// FIXME Esto es lento como su puta madre
		$esParticipante = false;
		foreach($accionGrupal['participaciones'] as $participacion){
			if ($participacion['usuarios_id_usuario'] == $usuario){
				$esParticipante = true;
			}
		}

		if($accionGrupal['completada'] == 1){
			Yii::app()->user->setFlash('completada', 'La acción se ha completado');
		}
		
		// Envío los datos a la vista
		$this->render('ver', array(
			'accionGrupal'=>$accionGrupal,
			'usuario'=>$usuario,
			'habilidad'=>$accionGrupal->habilidades,
			'propietarioAccion'=>$propietarioAccion,
			'esParticipante'=>$esParticipante,
			'equipoAccion' => $equipoAccion,
			'equipoUsuario' => $equipoUsuario));
	}

	/**
	 * Permite participar en una accion grupal abierta por tu aficion.
	 *
	 * Muestra el formulario que define que recursos va a aportar a la accion que se recogen por $_POST 
	 *
	 * > El id del jugador se recoge de la variable de sesion
	 * 
	 * @param int $id_accion   id de la accion en la que se va a participar
	 *
	 * @route jugadorNum12/acciones/participar/{$id}
	 * @redirect jugadorNum12/equipos/ver/{$id_equipo}
	 * 
	 * @throws \Exception      accion inexistente
     * @throws \Exception      habilidad inexistente
     * @throws \Excepcion      la accion no permite mas participantes
     * @throws \Excepcion      fallo en la transaccion
     *  
	 * @return void
	 */
	public function actionParticipar($id_accion)
	{
		// TODO: pasar logica al modelo

		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Iniciamos la transacción
		$transaccion = Yii::app()->db->beginTransaction();
			
		try {
			//Recojo los datos de la acción
			$accion = AccionesGrupales::model()->findByPK($id_accion);
			if($accion===null) {
				Yii::app()->user->setFlash('accion', 'Acción inexistente.');
				throw new Exception('Acción inexistente.');
			}

			//Recojo los datos de la habilidad
			$habilidad = Habilidades::model()->findByPk($accion['habilidades_id_habilidad']);

			if($habilidad==null) {
				Yii::app()->user->setFlash('habilidad', 'Habilidad inexistente.');
				throw new Exception('La habilidad no existe.');
			}

			//Saco el usuario que quiere participar en la acción
			$id_user = Yii::app()->user->usIdent;

			//Compuebo si el jugador ya ha participado en la acción
			$participacion= Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_user));
			$nuevo_participante= $participacion===null;

			if($nuevo_participante) {
				//Compruebo que no se sobrepase el límite de jugadores
				if($accion['jugadores_acc'] >= $habilidad['participantes_max']) {
					Yii::app()->user->setFlash('participantes', 'La acción no permite más participantes.');
					//$this-> redirect(array('acciones/index'));
					throw new Exception('La acción no permite más participantes.');
				}

			 	//Saco el modelo que le voy a pasar a la vista
				$participacion = new Participaciones();
				$participacion['acciones_grupales_id_accion_grupal'] = $id_accion;
				$participacion['usuarios_id_usuario'] = $id_user;
			}

			$participacion->setScenario('participar');

			// Comprobar si hay recursos a aportar
			if( !isset($_POST['Participaciones'])) {
				$transaccion->rollback();
				//Petición GET: Muestro el formulario
				$this->render('participar', array('habilidad' => $habilidad, 'participacion' => $participacion,
													'accion'=> $accion));
				return;
			}

			//Petición POST
			$recursosAportados = $_POST['Participaciones'];

			// Llamar a función del modelo AccionesGrupales para participar en la misma
			AccionesGrupales::participar($id_accion, $recursosAportados, $accion, $habilidad, $participacion, $nuevo_participante);

			$transaccion->commit();
			$this-> redirect(array('acciones/ver','id_accion'=>$id_accion));

		} catch ( Exception $exc ) {
			$transaccion->rollback();
			$this-> redirect(array('acciones/ver','id_accion'=>$id_accion));
			throw $exc;
		}
	}

	/** 
     * Expulsar a un jugador participante en una accion grupal
     *
	 * Los recursos que puso el jugador le son devueltos comprobando limite de animo e influencias
	 * 
	 * @param int $id_accion   id de la accion de donde se va a expulsar al jugador
	 * @param int $id_jugador  id del jugador que se va a expulsar
     *
	 * @route jugadorNum12/acciones/expulsar/{$id_accion}/{$id_jugador}
	 * @redirect jugadorNum12/acciones/ver/{$id_accion}
     *
     * @throws \Exception      fallo en la transaccion
     * @return void
	 */
	public function actionExpulsar($id_accion, $id_jugador)
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Empieza la transacción
		$trans = Yii::app()->db->beginTransaction();
		try {
			AccionesGrupales::expulsarJugador($id_accion, $id_jugador);
			$trans->commit();
		} catch (Exception $exc) {
    		$trans->rollback();
    		$this-> redirect(array('acciones/ver', 'id_accion'=>$id_accion));
		}

		// redirect
		$this-> redirect(array('acciones/ver', 'id_accion'=>$id_accion));
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
		$model=AccionesGrupales::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='acciones-grupales-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
