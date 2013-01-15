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
		//Sacar una lista de las acciones desbloqueadas de un usuario
		$accionesDesbloqueadas = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//Sacar una lista con los recursos del usuario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));

		//A partir de las acciones sacamos las habilidades para poder mostrarlas
		$acciones = array();
		foreach ($accionesDesbloqueadas as $habilidad){
			$acciones[] = Habilidades::model()->findByPK($habilidad['habilidades_id_habilidad']);
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
	 *   Si es una accion individual o pasiva se ejecuta al momento
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
		// El parámetro $id_accion es en realidad el ID de la habilidad

		// echo '<pre>'.print_r(Yii::app()->user,true).'</pre>';
		$trans = Yii::app()->db->beginTransaction();
		$habilidad = Habilidades::model()->findByPk($id_accion);

		if ( $habilidad == null ) {
			// Habilidad no encontrada
			$trans->rollback();
			throw new CHttpException(404,'Acción inexistente.');

		} else {
			// TODO Comprobar que el usuario ha desbloqueado la acción

			if ( $habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL ) {
				if ( Yii::app()->request->isPostRequest ) {
					// Petición POST: Procesar la acción
					$formDin = Yii::app()->request->getPost('dinero');
					$formAni = Yii::app()->request->getPost('animo');
					$formInf = Yii::app()->request->getPost('influencia');

					// Si no son suficientes recursos, pedir otra entrada al usuario
					if ( $formDin < $habilidad['dinero']
					  || $formAni < $habilidad['animo']
					  || $formInf < $habilidad['influencias']
					) {
						$trans->rollback();

						Yii::app()->user->setFlash('error', 'Recursos demasiado bajos');
						$this->refresh();
					}

					// Comprobar ahora que el usuario tiene recursos suficientes
					$res = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => Yii::app()->user->id));
					$actDin = $res['dinero'];
					$actAni = $res['animo'];
					$actInf = $res['influencias'];

					if ($actDin < $formDin || $actAni < $formAni || $actInf < $formInf) {
						$trans->rollback();

						Yii::app()->user->setFlash('error', 'No tienes suficientes recursos');
						$this->refresh();
					}

					try {
						$res['dinero'] = $actDin - $formDin;
						$res['animo'] = $actAni - $formAni;
						$res['influencias'] = $actInf - $formInf;
						$res->save();

						$idUsuario = Yii::app()->user->id;
						$idAficion = 0;

						$accion = new AccionesGrupales();
						$accion['usuarios_id_usuario'] = $idUsuario;
						$accion['habilidades_id_habilidad'] = $habilidad['id_habilidad'];
						$accion['equipos_id_equipo'] = $idAficion;
						$accion['dinero_acc'] = $formDin;
						$accion['animo_acc'] = $formAni;
						$accion['influencias_acc'] = $formInf;
						/* TODO Resto de cosas que no sé qué son
						$accion['jugadores_acc'] = <?>;
						$accion['finalizacion'] = <?>;
						*/
						$accion->save();

						$trans->commit();

					} catch ( Exception $exc ) {
						$trans->rollback();
						throw $exc;
					}

				} else {
					// Petición GET: Mostrar formulario de recursos
					$trans->commit();
					$this->render('usar', array('habilidad'=>$habilidad));
				}

			} else if ( $habilidad['tipo'] == Habilidades::TIPO_GRUPAL ) {
				// Habilidad Grupal: TODO
				$trans->rollback();

			} else {
				// La acción no es de ningún tipo conocido
				// TODO Soltar un error de tres pares de huevos
				$trans->rollback();
			}
		}
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
		//Cojo la acción de la tabla acciones_grupales
		$accionGrupal = AccionesGrupales::model()->findByPK($id_accion);

		//A partir de la acción saco la habilidad para poder mostrar los datos
		$habilidad = Habilidades::model()->findByPK($accionGrupal['habilidades_id_habilidad']);
		if($habilidad <> null){

			//Saco las participaciones de la acción
			$participaciones = Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal' => $id_accion));

			//Saco el usuario
			$usuario = Yii::app()->user->usIdent;

			//Saco el propietario de la acción
			$propietarioAccion = $accionGrupal['usuarios_id_usuario'];

			//Saco el usuario que quiere participar en la acción y su equipo
			$datosUsuario = Usuarios::model()->findByPK($usuario);
			$equipoUsuario = $datosUsuario['equipos_id_equipo'];

			//Saco el equipo que ha creado la accion
			$equipoAccion = $accionGrupal['equipos_id_equipo'];

			//Compruebo si el usuario ha participado ya en la accion
			$esParticipante = false;
			foreach($participaciones as $participacion){
				if ($participacion['usuarios_id_usuario'] == $usuario){
					$esParticipante = true;
				}
			}
			
			//Envío los datos a la vista
			$this->render('ver', array('accionGrupal'=>$accionGrupal, 'habilidad'=>$habilidad,
						 'usuario'=>$usuario, 'propietarioAccion'=>$propietarioAccion, 'participaciones'=>$participaciones,
						 'esParticipante'=>$esParticipante, 'equipoAccion' => $equipoAccion, 'equipoUsuario' => $equipoUsuario));
		}
		else{
			echo "La accion no existe.";
		}
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
		/* PEDRO pero cualquier duda preguntar a MARCOS*/
		//Recojo los datos de la acción
		$accion = AccionesGrupales::model()->findByPK($id_accion);
		if($accion==null)
			throw new CHttpException(404,'Acción inexistente.');

		//Recojo los datos de la habilidad
		$id_habilidad= $accion['habilidades_id_habilidad'];
		$habilidad = Habilidades::model()->findByPk($id_accion);
		if($habilidad==null)
			throw new CHttpException(501,'La habilidad no existe.');

		//Saco el usuario que quiere participar en la acción
		$id_user = Yii::app()->user->usIdent;
		$usuario = Usuarios::model()->findByPK($id_user);

		//Compruebo que la acción es del equipo del user
		if($accion['equipos_id_equipo']!= $usuario['equipos_id_equipo'])
			throw new CHttpException(403,'Por favor limitese a las acciones de su equipo.');

		//Iniciamos la transacción
		$transaccion = Yii::app()->db->beginTransaction();

		//Compruebo que la acción no ha terminado
		if ($accion['completada'] != 0)
			throw new CHttpException(403,'La acción indicada ya ha acabado.');

		//Compuebo si el jugador ya ha participado en la acción
		$participacion=Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_user));
		if($participacion==null){
			//Compruebo que no se sobrepase el límite de jugadores
			if($accion['jugadores_acc'] >= $habilidad['participantes_max'])
		 		throw new CHttpException(403,'La acción ha alcanzado el número máximo de participantes.');
			
		 	//Saco el modelo que le voy a pasar a la vista
			$participacion = new Participaciones();
			$participacion['acciones_grupales_id_accion_grupal'] = $id_accion;
			$participacion['usuarios_id_usuario'] = $id_user;
			$participacion['dinero_aportado'] = 0;
			$participacion['influencias_aportadas'] = 0;
			$participacion['animo_aportado'] = 0;
			$nuevo_participante=true;
		}else $nuevo_participante=false;

		$participacion->setScenario('participar');

		//Saco los recursos del ususario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_user));
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

		//creo que esto es lo que comprueba las rules (ajax)
		$participacion->setAttributes(array('dinero_nuevo'=>$dineroAportado, 'animo_nuevo'=>$animoAportado, 'influencia_nueva'=>$influenciasAportadas));

		if ( $dineroAportado > $dineroUsuario || $animoAportado > $animoUsuario || $influenciasAportadas > $influenciasUsuario){
			$transaccion->rollback();

			//este script equivale al flash y el redirect
			$url_redirecct = $this->createUrl('acciones/participar', array('id_accion'=>$id_accion));
			echo '<script type="text/javascript">'.
				 'alert("Recursos insuficientes.");'.
				 'window.location = "'.
				  $url_redirecct.
				 '"</script>';
			//fin del script

			return;
		}
			
		try {
			//Compruebo que los recursos aportados no sobrepasan los que faltan para terminar la acción
			$dineroAportado = min($dineroAportado, $habilidad['dinero_max'] - $accion['dinero_acc']);
			$animoAportado = min($animoAportado, $habilidad['animo_max'] - $accion['animo_acc']);
			$influenciasAportadas = min($influenciasAportadas, $habilidad['influencias_max'] - $accion['influencias_acc']);

			//Esto es un poco paranoico, pero dejarlo pasar sería una burrada (y no se como se valida el formulario)
			if($dineroAportado<0 || $animoAportado<0 || $influenciasAportadas<0){
				Yii::log('[MALICIOUS_REQUEST] El usuario '.$id_user.' se ha saltado una validación de seguridad, intentando robar recursos de la accion '.$id_accion, 'warning');
				throw new CHttpException(403,'Ten cuidado o acabarás baneado');
			}

			//Si no se aporta nada ignoro la petición
			if($dineroAportado==0 && $animoAportado==0 && $influenciasAportadas==0){
				$transaccion->rollback();
				$this->redirect(array('ver', 'id_accion'=>$id_accion));
				return;
			}

			//Resto los recursos al usuario
			$recursosUsuario['dinero'] = $dineroUsuario - $dineroAportado;
			$recursosUsuario['animo'] = $animoUsuario - $animoAportado;
			$recursosUsuario['influencias'] = $influenciasUsuario - $influenciasAportadas;
				
			//Añado los recursos en acciones_grupales
			if($nuevo_participante) $accion['jugadores_acc'] += 1;
			$accion['dinero_acc'] += $dineroAportado;  
			$accion['influencias_acc'] += $influenciasAportadas;
			$accion['animo_acc'] += $animoAportado;

			//Calculo la participación
			$participacion['dinero_aportado'] += $dineroAportado;
			$participacion['influencias_aportadas'] += $influenciasAportadas;
			$participacion['animo_aportado'] += $animoAportado;

			//Compruebo si ya se han aportado todos los recursos necesarios para la acción
			if ($accion['dinero_acc'] == $habilidad['dinero_max'] && $accion['influencias_acc'] == $habilidad['influencias_max'] && $accion['animo_acc'] == $habilidad['animo_max'])
					$accion['completada'] = 1;
				

			$recursosUsuario->save();
			$accion->save();
			$participacion->save();
				
			$transaccion->commit();
			
			//este script equivale al flash y el redirect
			$url_redirecct = $this->createUrl('acciones/ver', array('id_accion'=>$id_accion));
			echo '<script type="text/javascript">'.
				 'alert("Tu equipo agradece tu generosa contribucion.");'.
				 'window.location = "'.
				  $url_redirecct.
				 '"</script>';
			//fin del script

			//$this->redirect(array('ver', 'id_accion'=>$id_accion));
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
		/* MARCOS */
		//Empieza la transacción
		$trans = Yii::app()->db->beginTransaction();
		try{

			$acc = AccionesGrupales::model()->findByPk($id_accion);
			$rec = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_jugador));
			$part = Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_jugador));
			
			//Se comprueba la coherencia de la petición
			if($acc == null)
				throw new CHttpException(404,'Acción inexistente.');
			if($acc['usuarios_id_usuario']!= Yii::app()->user->usIdent) 
				throw new CHttpException(401,'No tienes privilegios sobre la acción.');
			if($part == null)
				throw new CHttpException(404,'El jugador indicado no partricipa en la acción.');

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
				Yii::log('[DATABASE_ERROR] El usuario '.$id_jugador.' tiene multiples participaciones en la acción '.$id_accion,'error');
				throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
			}

			$trans->commit();

		}catch(Exception $exc) {
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
