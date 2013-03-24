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
		/* MARCOS */
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
			Yii::import('application.components.Helper');

			$helper = new Helper();

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
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'dinero',$dinero);
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'animo',$animo);
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'influencias',$influencia);

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
			Yii::import('application.components.Helper');
			$helper = new Helper();
			
			// 1. Devolver recursos a los participantes (incluido el creador)
			$participantes=Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $id_accion_grupal));

			//Recorrer todos los participantes devolviendoles sus recursos
			foreach ($participantes as $participante)
			{
				// Aumentar recursos a los participantes
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'dinero', $participante->dinero_aportado);
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'animo', $participante->animo_aportado);
				$helper->aumentar_recursos($participante->usuarios_id_usuario,'influencias', $participante->influencias_aportadas);

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
}
