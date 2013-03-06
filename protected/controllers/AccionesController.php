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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Sacar una lista de las acciones desbloqueadas de un usuario
		$accionesDesbloqueadas = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Sacar una lista con los recursos del usuario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Comprobaciones de seguridad
		if (($accionesDesbloqueadas === null) || ($recursosUsuario === null))
			throw new Exception("Acciones o recursos no encontrados. (actionIndex, AccionesController)", 404);
			
		//A partir de las acciones sacamos las habilidades para poder mostrarlas
		$acciones = array();
		foreach ($accionesDesbloqueadas as $habilidad)
		{
			$hab = Habilidades::model()->findByPK($habilidad['habilidades_id_habilidad']);

			//Comprobación de seguridad
			if ($hab === null)
				throw new Exception("Habilidad no encontrada. (actionIndex,AccionesController)", 404);
				
			$acciones[] = $hab;
		}

		//Envía los datos para que los muestre la vista
		$this->render('index',array('acciones'=>$acciones, 'recursosUsuario'=>$recursosUsuario));
	}

	/**
	 * Ejecuta la accion (individual o grupal) pulsada (no habrá acciones pasivas o de partido)
	 * Significa "bajarse la carta de habilidad"
	 *
	 * Cualquier habilidad resta los recursos iniciales al jugador, además,
	 *
	 *   Si es una accion grupal muestra un formulario para recoger la 
	 * cantidad inicial de recursos que aporta el jugador (podría no aportar recursos), 
	 * Los datos del formulario se recogen por $_POST y se crea una 
	 * nueva accion grupal en el equipo al que pertenece el usuario
	 *   Si es una accion individual se ejecuta al momento
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Comenzar transaccion
		$trans = Yii::app()->db->beginTransaction();
		Yii::import('application.components.Acciones.*');
		//Cojo el id_usuario
		$id_usuario=Yii::app()->user->usIdent;
		//Obtener modelo de Habilidades
		$habilidad = Habilidades::model()->findByPk($id_accion);

		//Habilidad no encontrada
		if ( $habilidad === null ) {			
			$trans->rollback();
			throw new CHttpException(404,'Acción inexistente.');
		}

		//Habilidad encontrada
		//Obtener modelo de Desbloqueadas		
		$desbloqueada = Desbloqueadas::model()->findByAttributes(array('usuarios_id_usuario' => $id_usuario,
																   	   'habilidades_id_habilidad' => $id_accion ));			
		//Si no esta desbloqueada para el usuario, error
		if( $desbloqueada === null){				
			$trans->rollback();
			throw new CHttpException(404,'No tienes desbloqueada la acción.');
		} 
		
		//Si esta desbloqueada
		//Obtener modelo de Recursos
		$res = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_usuario));
		
		//Si no son suficientes recursos cancelar transaccion y notificar al usuario
		if ( $res['dinero'] 	 < $habilidad['dinero'] ||
		     $res['animo'] 		 < $habilidad['animo']  ||
		     $res['influencias'] < $habilidad['influencias']){
			
			$trans->rollback();
			throw new CHttpException(404,'No tienes suficientes recursos');
		}

		//Si tenemos suficientes recursos miramos si es individual o grupal
		if ( $habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL ) { 
			
			//Sacar la accion individual teniendo en cuenta el id_usuario,e id_habilidad 
			//y cogiendo la que mayor cooldown tiene de toda la tabla
			$criteria = new CDbCriteria();
			$criteria->addCondition('usuarios_id_usuario=:bid_usuario');
			$criteria->addCondition('habilidades_id_habilidad=:bid_accion');
			$criteria->addCondition('devuelto = 0');
			$criteria->params = array(	'bid_usuario' => $id_usuario,
										'bid_accion' => $id_accion,
										);	
			$criteria->order = 'cooldown DESC';
			$criteria->limit = '1';
			$accion_ind = AccionesIndividuales::model()->find($criteria);
			$tiempo_reg = $habilidad['cooldown_fin'];		//tiempo que tarda en regenerarse (cte.)
			
			//Si no estaba creada, crear con cooldown = 0 
			if($accion_ind === null){
				$accion_ind = new AccionesIndividuales();
				$accion_ind->setAttributes(	array('usuarios_id_usuario' => $id_usuario,
				   							  	  'habilidades_id_habilidad' => $id_accion,
				   							  	  'cooldown' => 0 ,
				   							  	  'devuelto'=> 1));
			}

			// TODO Sacar la hora actual
			$hora_act = time(); 			

			// TODO Sacar el cooldown de la accion individual
			$hora_cooldown = $accion_ind->cooldown; 	//hora en la que acaba de regenerarse

			// Si  hora < hora_cooldown,
			// cancelar transaccion y notificar al usuario
			if ( $hora_act < $hora_cooldown ){
					$trans->rollback();
					throw new CHttpException(404,'La habilidad no se ha regenerado todavía.');
			} 

			//Si hora >= hora_cooldown			
			//restar recursos al usuario
			try{			
				$res['dinero'] 		-= $habilidad['dinero'];
				$res['animo']  		-= $habilidad['animo'];
				$res['influencias'] -= $habilidad['influencias'];
				$res->save();

				//actualizar la hora en que acaba de regenerarse la accion
				$accion_ind->cooldown = $hora_act + $tiempo_reg;
				$accion_ind->devuelto=0;
				
				//guardar en los modelo				
				$accion_ind->save();

				//TODO suficientes recursos y hora >= cooldown -> ejecutar accion
				//Tomar nombre de habilidad para instanciación dinámica
        		$hab = Habilidades::model()->findByPk($id_accion);
        		if ($hab === null)
        		{
        			throw new CHttpException(404,"Error: habilidad no encontrada. (AccionUsar.AccionesController)");
        			
        		}      
        		  		
        		$nombreHabilidad = $hab->codigo;

        		//Llamar al singleton correspondiente y ejecutar dicha acción
        		$nombreHabilidad::getInstance()->ejecutar($id_usuario);
			} catch ( Exception $exc ) {
					$trans->rollback();
					throw $exc;
			}										   
			
		} else if ( $habilidad['tipo'] == Habilidades::TIPO_GRUPAL ) {
				/*
					Se deberia obtener la accion grupal mediante su PK (id_accion_grupal)
					Como $id_accion equivale $id_habilidad por como se redirige desde acciones/index
					para obtener la accion grupal debo buscar por id_equipo y id_habilidad
					NOTA: no se contempla la posibilidad de en un mismo equipo haya varias acciones iguales
					pero con distinto creador (aunque dicha posibilidad existe) ya que debe arreglarse la redireccion
				*/
				//Sacar la accion grupal
				//$accion_grupal = AccionesGrupales::model()->findByPk($id_accion);
				$id_usuario=Yii::app()->user->usIdent;
				$id_equipo=Yii::app()->user->usAfic;
				$accion_grupal = AccionesGrupales::model()->findByAttributes(array('equipos_id_equipo' => $id_equipo,
				  															       'habilidades_id_habilidad' => $id_accion,
				  															       'usuarios_id_usuario' =>  $id_usuario,
				  															        ));
				
				//Si no esta creada
				if($accion_grupal === null){
					//restar recursos al usuario (recursos iniciales)	
					try{	
						$res['dinero'] 		-= $habilidad['dinero'];
						$res['animo']  		-= $habilidad['animo'];
						$res['influencias'] -= $habilidad['influencias'];
						
						//sumarselos al crear nueva accion grupal
						$accion_grupal = new AccionesGrupales();
						$accion_grupal->setAttributes( array('usuarios_id_usuario' => $id_usuario,
					   							  	         'habilidades_id_habilidad' => $id_accion,
					   							  	         'equipos_id_equipo' => $id_equipo,
					   							  	         'influencias_acc'   => $habilidad['influencias'],
					   							  	         'animo_acc' 	     => $habilidad['animo'],
															 'dinero_acc' 	     => $habilidad['dinero'],
															 'jugadores_acc'     => 0,
															 'finalizacion'      => $habilidad['cooldown_fin']+time(),													 
					   							  	         'completada' 	     => 0 ));
						//guardar en los modelos
						$res->save();
						$accion_grupal->save();
					} catch ( Exception $exc ) {
						$trans->rollback();
						throw $exc;
				    } 
					// sacar el id de accion grupal (pk)
					// TODO pasar a la vista algun parametro,
					// para que en este caso muestre al usuario un boton para poder ser el primero en participar				
				} else {
					//Si esta creada 
					//sacar el id de accion grupal (pk) y redirigir a participar($id_accion_grupal)
					$this-> redirect(array('acciones/participar',
										   'id_accion'=>$accion_grupal['id_accion_grupal'] ));
				}				

		} else { 
				//tipo erroneo
				$trans->rollback();
				throw new CHttpException(404,'No puedes usar esa acción.');
		}

		$trans->commit();

		//Redireccionar tras la ejecución
		if ($habilidad->tipo == Habilidades::TIPO_INDIVIDUAL)
		{			
        		$this->redirect(array('acciones/index'));
		}
		else
		{
			//COMPLETAR
		}
		$this->render('usar', array('id_acc'=>$accion_grupal['id_accion_grupal'],'habilidad'=>$habilidad, 'res'=>$res));
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
			throw new Exception("La acción grupal no existe.", 404);
			
		// Saco el usuario
		$usuario = Yii::app()->user->usIdent;
		$equipoUsuario = Yii::app()->user->usAfic;

		// Si el usuario no es del equipo de la acción, no tenemos permiso
		if ( $accionGrupal['equipos_id_equipo'] != $equipoUsuario ) 
					throw new CHttpException( 403, 'La acción no es de tu equipo');

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
		
		// Envío los datos a la vista
		$this->render('ver', array(
			'accionGrupal'=>$accionGrupal,
			'usuario'=>$usuario,
			'propietarioAccion'=>$propietarioAccion,
			'esParticipante'=>$esParticipante,
			'equipoAccion' => $equipoAccion,
			'equipoUsuario' => $equipoUsuario));
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		/* PEDRO pero cualquier duda preguntar a MARCOS*/
		//Recojo los datos de la acción
		$accion = AccionesGrupales::model()->findByPK($id_accion);
		if($accion===null)
			throw new CHttpException(404,'Acción inexistente.');

		//Recojo los datos de la habilidad
		$habilidad = Habilidades::model()->findByPk($accion['habilidades_id_habilidad']);
		if($habilidad===null)
			throw new CHttpException(501,'La habilidad no existe.');

		//Saco el usuario que quiere participar en la acción
		$id_user = Yii::app()->user->usIdent;

		//Compruebo que la acción es del equipo del user
		if($accion['equipos_id_equipo']!= Yii::app()->user->usAfic)
			throw new CHttpException(403,'Por favor limitese a las acciones de su equipo.');

		//Iniciamos la transacción
		$transaccion = Yii::app()->db->beginTransaction();

		//Compruebo que la acción no ha terminado
		if ($accion['completada'] != 0)
			throw new CHttpException(403,'La acción indicada ya ha acabado.');

		//Compuebo si el jugador ya ha participado en la acción
		$participacion= Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_user));
		$nuevo_participante= $participacion===null;

		if($nuevo_participante){
			//Compruebo que no se sobrepase el límite de jugadores
			if($accion['jugadores_acc'] >= $habilidad['participantes_max'])
		 		throw new CHttpException(403,'La acción ha alcanzado el número máximo de participantes.');
			
		 	//Saco el modelo que le voy a pasar a la vista
			$participacion = new Participaciones();
			$participacion['acciones_grupales_id_accion_grupal'] = $id_accion;
			$participacion['usuarios_id_usuario'] = $id_user;
		}

		$participacion->setScenario('participar');

		//Saco los recursos del ususario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_user));

		//Comprobación de seguridad
		if ($recursosUsuario === null)
			throw new CHttpException(404,"No se puede obtener el modelo de recursos. (actionParticipar,AccionesController)");
			
		$dineroUsuario = $recursosUsuario['dinero'];
		$influenciasUsuario = $recursosUsuario['influencias'];
		$animoUsuario = $recursosUsuario['animo'];

		if( !isset($_POST['Participaciones'])){
			$transaccion->rollback();
			//Petición GET: Muestro el formulario
			$this->render('participar', array('habilidad' => $habilidad, 'participacion' => $participacion));
			return;
		}

		//Petición POST
		$recursosAportados = $_POST['Participaciones'];
		$dineroAportado = $recursosAportados['dinero_nuevo'];
		$animoAportado = $recursosAportados['animo_nuevo'];
		$influenciasAportadas = $recursosAportados['influencia_nueva'];
		$participacion->setAttributes(array('dinero_nuevo'=>$dineroAportado, 'animo_nuevo'=>$animoAportado, 'influencia_nueva'=>$influenciasAportadas));
			//esta ultimo linea es para que el ajax compruebe las rules

		//Compruebo que el usuario tiene suficientes recursos
		if ( $dineroAportado > $dineroUsuario || $animoAportado > $animoUsuario || $influenciasAportadas > $influenciasUsuario){
			//script equivalente al flash y el redirect
			$url_redirecct = $this->createUrl('acciones/participar', array('id_accion'=>$id_accion));
			echo '<script type="text/javascript">'.
				 'alert("Recursos insuficientes.");'.
				 'window.location = "'.
				  $url_redirecct.
				 '"</script>';
			$transaccion->rollback();
			return;
		}
			
		try {
			//Compruebo que los recursos aportados no sobrepasan los que faltan para terminar la acción
			$dineroAportado = min($dineroAportado, $habilidad['dinero_max'] - $accion['dinero_acc']);
			$animoAportado = min($animoAportado, $habilidad['animo_max'] - $accion['animo_acc']);
			$influenciasAportadas = min($influenciasAportadas, $habilidad['influencias_max'] - $accion['influencias_acc']);

			//Esto no debería ocurrir nunca
			if($dineroAportado<0 || $animoAportado<0 || $influenciasAportadas<0){
				if($habilidad['dinero_max'] < $accion['dinero_acc']){
					Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más dinero del maximo ('.$accion['dinero_acc'].'/'.$habilidad['dinero_max'].').','error');
					throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				}elseif($habilidad['animo_max'] < $accion['animo_acc']){
					Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más animo del maximo ('.$accion['animo_acc'].'/'.$habilidad['animo_max'].').','error');
					throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				}elseif($habilidad['influencias_max'] < $accion['influencias_acc']){
					Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más influencia del maximo ('.$accion['influencias_acc'].'/'.$habilidad['influencias_max'].').','error');
					throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				}
				
				Yii::log('[MALICIOUS_REQUEST] El usuario '.$id_user.' se ha saltado una validación de seguridad, intentando robar recursos de la accion '.$id_accion, 'warning');
				throw new CHttpException(403,'Ten cuidado o acabarás baneado');
			}

			//Si no se aporta nada ignoro la petición
			if($dineroAportado==0 && $animoAportado==0 && $influenciasAportadas==0){
				$transaccion->rollback();
				$this->redirect(array('ver', 'id_accion'=>$id_accion));
				return;
			}

			//Actualizo los recursos del user
			$recursosUsuario['dinero'] = $dineroUsuario - $dineroAportado;
			$recursosUsuario['animo'] = $animoUsuario - $animoAportado;
			$recursosUsuario['influencias'] = $influenciasUsuario - $influenciasAportadas;
			$recursosUsuario->save();

			//Actualizo acciones_grupales
			$accion['dinero_acc'] += $dineroAportado;  
			$accion['influencias_acc'] += $influenciasAportadas;
			$accion['animo_acc'] += $animoAportado;
			if($nuevo_participante)
				$accion['jugadores_acc'] += 1;
			if ($accion['dinero_acc'] == $habilidad['dinero_max'] && $accion['influencias_acc'] == $habilidad['influencias_max'] && $accion['animo_acc'] == $habilidad['animo_max'])
				$accion['completada'] = 1;					
			
			
			//Actualizo la participación
			if($nuevo_participante){
				$participacion['dinero_aportado'] = $dineroAportado;
				$participacion['influencias_aportadas'] = $influenciasAportadas;
				$participacion['animo_aportado'] = $animoAportado;
				$participacion->save();
			}else{	
				$n=$participacion->updateAll(array( 'dinero_aportado'=>$participacion['dinero_aportado'] + $dineroAportado,
													'influencias_aportadas'=>$participacion['influencias_aportadas'] + $influenciasAportadas,
													'animo_aportado'=>$participacion['animo_aportado'] + $animoAportado),
											"acciones_grupales_id_accion_grupal=:id_accion && usuarios_id_usuario=:id_user",
											array(':id_accion'=>$id_accion, ':id_user'=>$id_user)); 
				if($n!=1){
					//Si salta esto es que había más de una participación del mismo usuario en la acción
					Yii::log('[DATABASE_ERROR] El usuario '.$id_user.' tiene '.$n.' participaciones en la acción '.$id_accion,'error');
					throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				}
			}
			//Si la accion esta completada con esa aportacion, ejecutas la accion sino es asi guardas los cambios en la accion
			if($accion['completada'] == 1)
			{
				$accion->save();
				Yii::import('application.components.Acciones.*');
				$nombreHabilidad = $habilidad->codigo;
        		//Llamar al singleton correspondiente y ejecutar dicha acción
        		$nombreHabilidad::getInstance()->ejecutar($id_accion);

			}else
				{
					$accion->save();
				}

			$transaccion->commit();
			
			//script equivalente al flash y el redirect
			$url_redirecct = $this->createUrl('acciones/ver', array('id_accion'=>$id_accion));
			echo '<script type="text/javascript">'.
				 'alert("Tu equipo agradece tu generosa contribucion.");'.
				 'window.location = "'.
				  $url_redirecct.
				 '"</script>';
		} catch ( Exception $exc ) {
			$transaccion->rollback();
			throw $exc;
		}
	}

	/** Expulsar a un jugador participante en una accion grupal.
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
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		/* MARCOS */
		//Empieza la transacción
		$trans = Yii::app()->db->beginTransaction();
		try{

			$acc = AccionesGrupales::model()->findByPk($id_accion);
			$rec = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_jugador));
			$part = Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_jugador));
			
			//Se comprueba la coherencia de la petición
			if ($rec === null)
			{
				throw new CHttpException(404,'Recursos inexistentes. (actionExpulsar,AccionesController)');
			}
			if ($acc === null) {
				throw new CHttpException(404,'Acción inexistente.');
			}
			if ($acc['usuarios_id_usuario']!= Yii::app()->user->usIdent) {
				throw new CHttpException(401,'No tienes privilegios sobre la acción.');
			}
			if ($id_jugador == Yii::app()->user->usIden) {
				throw new CHttpException(401,'No puedes expulsarte a ti mismo.');
			}
			if ($part === null) {
				throw new CHttpException(401,'El jugador indicado no partricipa en la acción.');
			}

			$actAni = $rec['animo'];
			$actInf = $rec['influencias'];
			$maxAni = $rec['animo_max'];
			$maxInf = $rec['influencias_max'];
			$partDin = $part['dinero_aportado'];
			$partAni = $part['animo_aportado'];
			$partInf = $part['influencias_aportadas'];

			$rec['dinero'] += $partDin;
			$rec['animo'] = min(($actAni + $partAni), $maxAni);
			$rec['influencias'] = min(($actInf + $partInf), $maxInf);
			$rec->save();

			$acc['jugadores_acc'] -= 1;
			$acc['dinero_acc'] -= $partDin;
			$acc['animo_acc'] -= $partAni;
			$acc['influencias_acc'] -= $partInf;
			$acc->save();

			//$part->delete(); // elegante, pero no funciona
			$n = Participaciones::model()->deleteAllByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_jugador));

			if($n != 1) {
				//Si salta esto es que había más de una participación del mismo usuario en la acción
				Yii::log('[DATABASE_ERROR] El usuario '.$id_jugador.' tiene '.$n.' participaciones en la acción '.$id_accion,'error');
				throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
			}

			$trans->commit();

		} catch (Exception $exc) {
    		$trans->rollback();
    		throw $exc;
		}

		$this-> redirect(array('acciones/ver', 'id_accion'=>$id_accion));
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
