<?php

/**
 * Modelo para la tabla <<acciones_grupales>>
 *
 * columnas disponibles:
 * string $id_accion_grupal
 * string $usuarios_id_usuario
 * string $habilidades_id_habilidad
 * string $equipos_id_equipo
 * string $influencias_acc
 * string $animo_acc
 * string $dinero_acc
 * string $jugadores_acc
 * string $finalizacion
 */
class AccionesGrupales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionesGrupales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acciones_grupales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc, finalizacion, completada', 'required'),
			array('usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc', 'length', 'max'=>10),
			array('finalizacion', 'length', 'max'=>11),
			array('completada', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_accion_grupal, usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc, finalizacion, completada', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_grupales - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		return array(
			//relacion con tablas de la arquitectura (1ª iteración)
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
			'habilidades'=>array(self::BELONGS_TO, 'Habilidades', 'habilidades_id_habilidad'),
			'equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo'),
			'participaciones'=>array(self::HAS_MANY, 'Participaciones', 'acciones_grupales_id_accion_grupal')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_accion_grupal' => 'Id Accion Grupal',
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'habilidades_id_habilidad' => 'Habilidades Id Habilidad',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'influencias_acc' => 'Influencias Acc',
			'animo_acc' => 'Animo Acc',
			'dinero_acc' => 'Dinero Acc',
			'jugadores_acc' => 'Jugadores Acc',
			'finalizacion' => 'Finalizacion',
			'completada' => 'Completada',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_accion_grupal',$this->id_accion_grupal,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('influencias_acc',$this->influencias_acc,true);
		$criteria->compare('animo_acc',$this->animo_acc,true);
		$criteria->compare('dinero_acc',$this->dinero_acc,true);
		$criteria->compare('jugadores_acc',$this->jugadores_acc,true);
		$criteria->compare('finalizacion',$this->finalizacion,true);
		$criteria->compare('completada',$this->finalizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
	* Esta función finaliza todas las acciones grupales no terminadas a tiempo.
	*/
	public function finalizaGrupales()
	{
		try
		{
			//Traer acciones y Helper	
			Yii::import('application.components.Acciones.*');

			$tiempo = time();
			$busqueda=new CDbCriteria;
			$busqueda->addCondition(':bTiempo >= finalizacion');
			$busqueda->addCondition('completada = :bCompletada');
			$busqueda->params = array(':bTiempo' => $tiempo,
									':bCompletada' => 0,
									);
			$transaction = Yii::app()->db->beginTransaction();

			$grupales = AccionesGrupales::model()->findAll($busqueda);

			//Iterar sobre las acciones grupales resultantes de la búsqueda
			foreach ($grupales as $gp)
			{		
				//Tomar participaciones
				$participantes = Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $gp->id_accion_grupal));
				//Recorro todos los participantes devolviendoles sus recursos.
				//Esto incluye el creador de la acción.
				foreach ($participantes as $participante)
				{
					//Cojo el dinero,influencia y animo aportado por el usuario
					$dinero=$participante->dinero_aportado;
					$influencia=$participante->influencias_aportadas;
					$animo=$participante->animo_aportado;

					//Utilizo el helper para ingresarle al usuario los recursos
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'dinero',$dinero);
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'animo',$animo);
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'influencias',$influencia);

					//Eliminar ese modelo
					Participaciones::model()->deleteAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $gp->id_accion_grupal,'usuarios_id_usuario'=> $participante->usuarios_id_usuario));
				}

				//Borro esa accion grupal iniciada por el usuario que quiere cambiar de equipo
				AccionesGrupales::model()->deleteByPk($gp->id_accion_grupal);
			}
			//Finalizar transacción con éxito
			$transaction->commit();  
		}
    	catch (Exception $ex)
    	{
    		//Rollback de la transacción en caso de error
    		$transaction->rollback();
    		//throw $ex;
    	}		
	}

	// Función para finalizar una grupal dada y devolver los recursos. Recibe
	// booleano para indicar si se debe borrar la acción.
	public static function finalizaGrupal($id_accion_grupal, $eliminar = true)
	{
		try
		{		
			// 1. Devolver recursos a los participantes (incluido el creador)
			$participantes=Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $id_accion_grupal));

			//Recorrer todos los participantes devolviendoles sus recursos
			foreach ($participantes as $participante)
			{
				// Aumentar recursos a los participantes
				Recursos::aumentar_recursos($participante->usuarios_id_usuario,'dinero', $participante->dinero_aportado);
				Recursos::aumentar_recursos($participante->usuarios_id_usuario,'animo', $participante->animo_aportado);
				Recursos::aumentar_recursos($participante->usuarios_id_usuario,'influencias', $participante->influencias_aportadas);

				// 2. Eliminar ese modelo
				Participaciones::model()->deleteAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $id_accion_grupal,'usuarios_id_usuario'=> $participante->usuarios_id_usuario));		
			}
			// 3. Borrar grupal si es necesario
			if ($eliminar)
			{
				AccionesGrupales::model()->deleteByPk($id_accion_grupal);
			}
		}
		catch (Exception $e)
		{
			// Dejar el try/catch para permitir posible logging de excepciones
			throw $e;
		}
	}	

	// Función expulsa a un jugador de una acción grupal dada
	public static function expulsarJugador($id_accion, $id_jugador)
	{
		$acc = AccionesGrupales::model()->findByPk($id_accion);
		$rec = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_jugador));
		$part = Participaciones::model()->findByAttributes(array('acciones_grupales_id_accion_grupal'=>$id_accion,'usuarios_id_usuario'=>$id_jugador));
		
		//Se comprueba la coherencia de la petición
		if ($rec === null)
		{
			Yii::app()->user->setFlash('recursos', 'Recursos inexistentes. (actionExpulsar,AccionesController).');
			throw new Exception('Recursos inexistentes. (actionExpulsar,AccionesController)');
		}
		if ($acc === null) {
			Yii::app()->user->setFlash('accion', 'Acción inexistente.');
			throw new CHttpException('Acción inexistente.');
		}
		if ($acc->completada == 1) {
			Yii::app()->user->setFlash('expulsar', 'Acción completada.No puedes expulsar.');
			throw new CHttpException('Acción completada.No puedes expulsar.');
		}
		if ($acc['usuarios_id_usuario']!= Yii::app()->user->usIdent) {
			Yii::app()->user->setFlash('privilegios', 'No tienes privilegios sobre la acción.');
			throw new CHttpException('No tienes privilegios sobre la acción.');
			//$this-> redirect(array('acciones/ver','id_accion'=>$id_accion));
		}
		if ($id_jugador == Yii::app()->user->usIdent) {
			Yii::app()->user->setFlash('error', 'No puedes expulsarte a tí mismo.');
			throw new CHttpException('No puedes expulsarte a tí mismo.');
			//$this-> redirect(array('acciones/ver','id_accion'=>$id_accion));
		}

		if ($part == null) {
			Yii::app()->user->setFlash('participante', 'El jugador indicado no participa en la acción.');
			throw new CHttpException('El jugador indicado no participa en la acción.');
			//$this-> redirect(array('acciones/ver','id_accion'=>$id_accion));
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

		if($n != 1) 
		{
			//Si salta esto es que había más de una participación del mismo usuario en la acción
			Yii::log('[DATABASE_ERROR] El usuario '.$id_jugador.' tiene '.$n.' participaciones en la acción '.$id_accion,'error');
			Yii::app()->user->setFlash('base_datos', 'Error en la base de datos. Pongase en contacto con un administrador.');
			throw new Exception('Error en la base de datos. Pongase en contacto con un administrador.');
		}
	}

	// Función que agrega una participación a una accion grupal
	public static function participar($id_accion, $recursosAportados, $accion, $habilidad, $participacion, $nuevo_participante)
	{
		$dineroAportado = $recursosAportados['dinero_nuevo'];
		$animoAportado = $recursosAportados['animo_nuevo'];
		$influenciasAportadas = $recursosAportados['influencia_nueva'];

		//Saco el usuario que quiere participar en la acción
		$id_user = Yii::app()->user->usIdent;

		//Compruebo que la acción es del equipo del user
		if($accion['equipos_id_equipo']!= Yii::app()->user->usAfic){
			Yii::app()->user->setFlash('equipo', 'No puedes participar en esta acción.');
			//$this-> redirect(array('acciones/index'));
			throw new Exception('No puedes participar en esta acción.');
		}

		//Compruebo que la acción no ha terminado
		if ($accion['completada'] != 0)
		{
			Yii::app()->user->setFlash('acabada', 'La acción ya ha acabado.');
			//$this-> redirect(array('acciones/index'));
			throw new Exception('La acción ya ha acabado.');
		}

		//Saco los recursos del ususario
		$recursosUsuario = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_user));

		//Comprobación de seguridad
		if ($recursosUsuario === null)
		{
			Yii::app()->user->setFlash('recursos', 'No se puede obtener el modelo de recursos. (actionParticipar,AccionesController).');
			//throw new CHttpException(404,"No se puede obtener el modelo de recursos. (actionParticipar,AccionesController)");
			//$this-> redirect(array('acciones/index'));
			throw new Exception('No se puede obtener el modelo de recursos.');
		}

		$dineroUsuario = $recursosUsuario['dinero'];
		$influenciasUsuario = $recursosUsuario['influencias'];
		$animoUsuario = $recursosUsuario['animo'];

		$participacion->setAttributes(array('dinero_nuevo'=>$dineroAportado, 'animo_nuevo'=>$animoAportado, 'influencia_nueva'=>$influenciasAportadas));

		//Compruebo que el usuario tiene suficientes recursos
		if ( $dineroAportado > $dineroUsuario || $animoAportado > $animoUsuario || $influenciasAportadas > $influenciasUsuario)
		{
			//No tiene suficientes recursos
			Yii::app()->user->setFlash('recursos', 'No tienes suficientes recursos.');
			//$this-> redirect(array('acciones/index'));
			throw new Exception('No tienes suficientes recursos.');
		}

		//Compruebo que los recursos aportados no sobrepasan los que faltan para terminar la acción
		$dineroAportado = min($dineroAportado, $habilidad['dinero_max'] - $accion['dinero_acc']);
		$animoAportado = min($animoAportado, $habilidad['animo_max'] - $accion['animo_acc']);
		$influenciasAportadas = min($influenciasAportadas, $habilidad['influencias_max'] - $accion['influencias_acc']);

		//Esto no debería ocurrir nunca
		if($dineroAportado<0 || $animoAportado<0 || $influenciasAportadas<0)
		{
			if($habilidad['dinero_max'] < $accion['dinero_acc'])
			{
				Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más dinero del maximo ('.$accion['dinero_acc'].'/'.$habilidad['dinero_max'].').','error');
				Yii::app()->user->setFlash('base_datos', 'Error en la base de datos. Pongase en contacto con un administrador.');
				//throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				//$this-> redirect(array('acciones/index'));
				throw new Exception('Error en la BBDD.');
			}
			elseif($habilidad['animo_max'] < $accion['animo_acc'])
			{
				Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más animo del maximo ('.$accion['animo_acc'].'/'.$habilidad['animo_max'].').','error');
				Yii::app()->user->setFlash('base_datos', 'Error en la base de datos. Pongase en contacto con un administrador.');
				//throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				//$this-> redirect(array('acciones/index'));
				throw new Exception('Error en la BBDD.');
			}
			elseif($habilidad['influencias_max'] < $accion['influencias_acc'])
			{
				Yii::log('[DATABASE_ERROR] La accion '.$id_accion.' más influencia del maximo ('.$accion['influencias_acc'].'/'.$habilidad['influencias_max'].').','error');
				Yii::app()->user->setFlash('base_datos', 'Error en la base de datos. Pongase en contacto con un administrador.');
				//throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				//$this-> redirect(array('acciones/index'));
				throw new Exception('Error en la BBDD.');
			}
			
			Yii::log('[MALICIOUS_REQUEST] El usuario '.$id_user.' se ha saltado una validación de seguridad, intentando robar recursos de la accion '.$id_accion, 'warning');
			Yii::app()->user->setFlash('aviso', 'Se ha registrado un intento de ataque al sistema. De no ser así, póngase en contacto con el administrador. Ten cuidado o acabarás baneado.');
			//$this-> redirect(array('acciones/index'));
				throw new Exception('El usuario se ha saltado una validación.');
		}

		//Si no se aporta nada ignoro la petición
		if($dineroAportado==0 && $animoAportado==0 && $influenciasAportadas==0)
		{
			Yii::app()->user->setFlash('aporte', 'No has aportado nada a la acción.');
			//$this-> redirect(array('acciones/index'));
			throw new Exception('No has aportado nada a la acción.');
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
			if($n!=1)
			{
				//Si salta esto es que había más de una participación del mismo usuario en la acción
				Yii::log('[DATABASE_ERROR] El usuario '.$id_user.' tiene '.$n.' participaciones en la acción '.$id_accion,'error');
				Yii::app()->user->setFlash('base_datos', 'Error en la base de datos. Pongase en contacto con un administrador.');
				//throw new CHttpException(500,'Error en la base de datos. Pongase en contacto con un administrador.');
				//$this-> redirect(array('acciones/index'));
				throw new Exception('Error en la BBDD.');
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


		if($accion['completada'] == 1)
		{
			Yii::app()->user->setFlash('completada', '¡Enhorabuena, has completado la acción¡');
		}
		else
		{
			Yii::app()->user->setFlash('aporte', 'Tu equipo agradece tu generosa contribución.');
		}
	}

	// Función para usar una acción grupal
	public static function usarGrupal($usuario, $id_accion, $id_equipo, $res, $habilidad)
	{		
		$id_usuario = $usuario->id_usuario;
		/*
			Se deberia obtener la accion grupal mediante su PK (id_accion_grupal)
			Como $id_accion equivale $id_habilidad por como se redirige desde acciones/index
			para obtener la accion grupal debo buscar por id_equipo y id_habilidad
			NOTA: no se contempla la posibilidad de en un mismo equipo haya varias acciones iguales
			pero con distinto creador (aunque dicha posibilidad existe) ya que debe arreglarse la redireccion
		*/	
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
											 'jugadores_acc'     => 1,
											 'finalizacion'      => $habilidad['cooldown_fin']+time(),													 
	   							  	         'completada' 	     => 0 ));
		//guardar en los modelos
		$res->save();
		$accion_grupal->save();
		
		//Crear participación del creador
		$participacion = new Participaciones();
		$participacion->acciones_grupales_id_accion_grupal = $accion_grupal->id_accion_grupal;
		$participacion->usuarios_id_usuario = $id_usuario;
		$participacion->dinero_aportado = $habilidad['dinero'];
		$participacion->influencias_aportadas = $habilidad['influencias'];
		$participacion->animo_aportado = $habilidad['animo'];
		if (!$participacion->save())
		{
			Yii::app()->user->setFlash('error', 'Participación no creada. (AccionesController,actionUsar.');
			throw new Exception("Participación no creada. (AccionesController,actionUsar)");	
		}

		// EXP: sumar experencia al usuario
		$usuario->sumarExp(Usuarios::MEDIA_EXP);
		//XXX
		return $accion_grupal['id_accion_grupal'];
	}
}
