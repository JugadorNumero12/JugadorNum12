<?php

/**
 * Modelo de la tabla <<recursos>>
 *
 * Columnas disponibles:
 * 	string $usuarios_id_usuario
 * 	string $dinero
 * 	double $dinero_gen
 * 	string $influencias
 * 	string $influencias_max
 * 	double $influencias_gen
 *  string influencias_bloqueadas
 * 	string $animo
 * 	string $animo_max
 * 	double $animo_gen
 */
class Recursos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recursos the static model class
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
		return 'recursos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen, bonus_dinero, bonus_influencias, bonus_animo, ultima_act, influencias_bloqueadas', 'required'),
			array('dinero_gen, influencias_gen, animo_gen', 'numerical'),
			array('usuarios_id_usuario, dinero, influencias, influencias_max, animo, animo_max, bonus_dinero, bonus_influencias, bonus_animo, influencias_bloqueadas', 'length', 'max'=>10),
			array('ultima_act', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen, influencias_bloqueadas', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <recursos - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* ALEX */
		return array( 
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'dinero' => 'Dinero',
			'dinero_gen' => 'Dinero Gen',
			'influencias' => 'Influencias',
			'influencias_max' => 'Influencias Max',
			'influencias_gen' => 'Influencias Gen',
			'influencias_bloqueadas' => 'Influencias Bloqueadas',
			'animo' => 'Animo',
			'animo_max' => 'Animo Max',
			'animo_gen' => 'Animo Gen',
			'bonus_animo' => 'Bonus de animo',
			'bonus_influencias' => 'Bonus de influencias',
			'bonus_dinero' => 'Bonus de dinero',
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

		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('dinero',$this->dinero,true);
		$criteria->compare('dinero_gen',$this->dinero_gen);
		$criteria->compare('influencias',$this->influencias,true);
		$criteria->compare('influencias_max',$this->influencias_max,true);
		$criteria->compare('influencias_gen',$this->influencias_gen);
		$criteria->compare('influencias_bloqueadas',$this->influencias_bloqueadas, true);
		$criteria->compare('animo',$this->animo,true);
		$criteria->compare('animo_max',$this->animo_max,true);
		$criteria->compare('animo_gen',$this->animo_gen); //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		$criteria->compare('bonus_animo',$this->animo_max,true); //<<<<<<<<<<<<<<<<<<<<<<<<<<<
		$criteria->compare('bonus_influencias',$this->animo_max,true); //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		$criteria->compare('bonus_dinero',$this->animo_max,true);//<<<<<<<<<<<<<<<<<<<<<<<<<<<

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function actualizaRecursos($id_usuario)
	{
		try
		{
			$animo_nuevo = 0;
			$dinero_nuevo = 0;
			$influencias_nuevas = 0;

			$ahora = time();

			$transaction = Yii::app()->db->beginTransaction();

			$rec = Recursos::model()->findByAttributes(array('usuarios_id_usuario' => $id_usuario));

			if ($rec === null)
				throw new Exception("Recursos inexistentes. ModeloRecursos (actualizaRecursos)", 404);

			//Tomar diferencia de minutos
			$dif_minutos = floor(($ahora - $rec->ultima_act)/60);

			if ($dif_minutos > 0)
			{
				//Solo actualizamos si han pasado ciertos minutos
				$animo_nuevo = round($rec->animo_gen * $dif_minutos);
				$dinero_nuevo = round($rec->dinero_gen * $dif_minutos);
				$influencias_nuevas = round($rec->influencias_gen * $dif_minutos);

				//Ultima actualización (para precisión total)
				//if ($rec->ultima_act == 0)
				//{
					$rec->ultima_act = $ahora;
				//}
				//else
				//{
				//	$rec->ultima_act + ($dif_minutos*60);
				//}

				if (!$rec->save())
					throw new Exception("Imposible guardar modelo de recursos. (actualizaRecursos,RecusosModel)", 500);					

				//influencias
				self::aumentar_recursos($rec->usuarios_id_usuario, "influencias", $influencias_nuevas);
				//dinero
				self::aumentar_recursos($rec->usuarios_id_usuario, "dinero", $dinero_nuevo);
				//animo
				self::aumentar_recursos($rec->usuarios_id_usuario, "animo", $animo_nuevo);
			}

			//Finalizar transacción con éxito
			$transaction->commit();  

			// Devolver recursos nuevos para ser actualizados por ajax en el partido
			return json_encode(array('influencias' => $influencias_nuevas,
									'dinero' => $dinero_nuevo,
									'animo' => $animo_nuevo,
								));
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			// Devolver recursos nuevos para ser actualizados por ajax en el partido
			return json_encode(array('influencias' => 0,
									'dinero' => 0,
									'animo' => 0,
								));
			//throw $e;			
		}	
	}

	public static function disminuir_influencias_bloqueadas($usr,$influencias_aportadas){

		$u = Usuarios::model()->findByPk($usr);
		if($u == null)return -1;
		$recursos=$u->recursos;
		if($recursos === null)return -1;
		$recursos['influencias_bloqueadas']-= $influencias_aportadas;
		if($recursos->save())return 0;
		else return -1;
	}

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que aumentamos
	 * @devuelve flag de error
	 * @ejemplo	Recursos::aumentar_recursos(3, "animo", 30);
	 */
	public static function aumentar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuarios::model()->findByPK($id_usuario);

		//Comprobación de seguridad
		if ($usuario === null)
		{
			throw new CHttpException(404,"Partido no encontrado. (aumentar_recursos,Helper.php)");
			
		}
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$valor_nuevo=$actuales + $cantidad;
				/*Debo comprobar que no esta o sobrepasa en su máximo el atributo*/

				/*En el caso del animo*/
				if( ($columna==='animo') && ($valor_nuevo >= $recursos->animo_max))
				{
					$recursos->$columna=$recursos->animo_max;

				}else if( ($columna==='influencias') && ($valor_nuevo >= $recursos->influencias_max-$recursos->influencias_bloqueadas))
						{
							$recursos->$columna=$recursos->influencias_max-$recursos->influencias_bloqueadas;

						}else 
							{
								$recursos->$columna=$valor_nuevo;
							}
				
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
		
	}

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que quitamos
	 * @devuelve flag de error
	 * @ejemplo	Recursos::quitar_recursos(3, "animo", 30);
	 */
	public static function quitar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuarios::model()->findByPK($id_usuario);

		//Comprobación de seguridad
		if ($usuario === null)
		{
			throw new CHttpException(404,"Partido no encontrado. (quitar_recursos,Helper.php)");
			
		}
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$recursos->$columna=$actuales - $cantidad;
				/*Al restar debo de comprobar que no sea valor negativo*/
				if($recursos->$columna < 0)
				{
					$recursos->$columna=0;
				}
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
	} 
}