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
		// El parámetro $id_accion es en realidad el ID de la habilidad

		echo '<pre>'.print_r(Yii::app()->user,true).'</pre>';
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
		/* PEDRO */
		//Cojo la acción de la tabla acciones_grupales
		$accionGrupal = AccionesGrupales::model()->findByPK($id_accion);

		//A partir de la acción saco la habilidad para poder mostrar los datos
		$habilidad = Habilidades::model()->findByPK($accionGrupal['habilidades_id_habilidad']);

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
		//Iniciamos la transaccion
		$transaccion = Yii::app()->db->beginTransaction();

		//Recojo los datos de la habilidad
		$habilidad = Habilidades::model()->findByPk($id_accion);

		//Saco el usuario que quiere participar en la acción y su equipo
		$usuario = Yii::app()->user->usIdent;
		$datosUsuario = Usuarios::model()->findByPK($usuario);
		$equipoUsuario = $datosUsuario['equipos_id_equipo'];

		//Saco el equipo que ha creado la accion
		$datosAccion = AccionesGrupales::model()->findByPK($id_accion);
		$equipoAccion = $datosAccion['equipos_id_equipo'];

		//Compruebo que la acción es del equipo del user, que la acción no ha terminado y que no se ha sobrepasado el límite de jugadores
		if ( $datosAccion != null && $equipoAccion == $equipoUsuario && $datosAccion['completada'] == 0 && $datosAccion['jugadores_acc'] < $habilidad['participantes_max']){
			//Saco el usuario que va a participar en la acción para luego sacar sus recursos
			$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $usuario));
			$dineroUsuario = $recursosUsuario['dinero'];
			$influenciasUsuario = $recursosUsuario['influencias'];
			$animoUsuario = $recursosUsuario['animo'];

			if( Yii::app()->request->isPostRequest ){
				//Petición POST
				$dineroAportado = Yii::app()->request->getPost('dinero');
				$animoAportado = Yii::app()->request->getPost('animo');
				$influenciasAportadas = Yii::app()->request->getPost('influencias');

				if ( $dineroAportado > $dineroUsuario || $animoAportado > $animoUsuario || $influenciasAportadas > $influenciasUsuario){
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', 'Recursos insuficientes');
					$this->refresh();
				}
				
				try {
					//Resta los recursos al usuario
					$recursosUsuario['dinero'] = $dineroUsuario - $dineroAportado;
					$recursosUsuario['animo'] = $animoUsuario - $animoAportado;
					$recursosUsuario['influencias'] = $influenciasUsuario - $influenciasAportadas;
					
					//Añade los recursos en acciones_grupales
					$datosAccion['jugadores_acc'] += 1;
					$datosAccion['dinero_acc'] += $dineroAportado;  
					$datosAccion['influencias_acc'] += $influenciasAportadas;
					$datosAccion['animo_acc'] += $animoAportado;

					//Añado una nueva participación en la tabla de participaciones
					$participacion = new Participaciones();
					$participacion['acciones_grupales_id_accion_grupal'] = $id_accion;
					$participacion['usuarios_id_usuario'] = $usuario;
					$participacion['dinero_aportado'] = $dineroAportado;
					$participacion['influencias_aportadas'] = $influenciasAportadas;
					$participacion['animo_aportado'] = $animoAportado;

					//Compruebo si ya se han aportado todos los recursos necesarios para la acción
					if ( $datosAccion['dinero_acc'] == $habilidad['dinero_max'] && $datosAccion['influencias_acc'] == $habilidad['influencias_max']
						&& $datosAccion['animo_acc'] == $habilidad['animo_max']){
						$datosAccion['completado'] = 1;
					}

					$recursosUsuario->save();
					$datosAccion->save();
					$participacion->save();
					
					$transaccion->commit();
					Yii::app()->user->setFlash('success', 'Se ha completado la acción con éxito');
					$this->redirect(array('ver', 'id_accion'=>$id_accion));
				} catch ( Exception $exc ) {
					$transaccion->rollback();
					throw $exc;
				}
			} else {
				//Petición GET: Muestro el formulario
				$transaccion->commit();
				$this->render('participar', array('habilidad' => $habilidad, 'datosAccion' => $datosAccion));
			}
		} else {
			$transaccion->rollback();
			throw new CHttpException(404,'El usuario no puede participar en esta acción');
		}
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

			if($n != 1)
				throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				//Si salta esto es que había más de una participación del mismo usuario en la acción

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
