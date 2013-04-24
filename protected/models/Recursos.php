<?php

/**
 * Modelo de la tabla recursos
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                    |
 * |:-------|:--------------------------| 	
 * | string | $usuarios_id_usuario      |
 * | string | $dinero                   |
 * | double | $dinero_gen               |
 * | string | $influencias              |
 * | string | $influencias_max          |
 * | double | $influencias_gen          |
 * | string | $animo                    |
 * | string | $animo_max                |
 * | double | $animo_gen                |
 *
 *
 * @package modelos
 */
class Recursos extends CActiveRecord
{
    /**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
     * @return \AccionesGrupales    el modelo estatico de la clase
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Devuelve el nombre de la tabla asociada a la clase
     *
     * > Funcion predeterminada de Yii
     * 
     * @return string   nombre de la tabla en la base de datos
     */
	public function tableName()
	{
		return 'recursos';
	}

    /**
     * Define las reglas definidas para los atributos del modelo.
     *
     * Incluye la regla usada por la funcion ```search()```
     * Deben definirse solo las reglas para aquellos atributos que reciban entrada del usuario
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     reglas de validacion para los atributos
     */
	public function rules()
	{
		return array(
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen, bonus_dinero, bonus_influencias, bonus_animo, ultima_act', 'required'),
			array('dinero_gen, influencias_gen, animo_gen', 'numerical'),
			array('usuarios_id_usuario, dinero, influencias, influencias_max, animo, animo_max, bonus_dinero, bonus_influencias, bonus_animo', 'length', 'max'=>10),
			array('ultima_act', 'length', 'max'=>11),
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Define las relaciones entre la tabla recursos y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - usuarios
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre recurso - tabla
     */
	public function relations()
	{
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
		$criteria->compare('animo',$this->animo,true);
		$criteria->compare('animo_max',$this->animo_max,true);
		$criteria->compare('animo_gen',$this->animo_gen);
		$criteria->compare('bonus_animo',$this->animo_max,true);
		$criteria->compare('bonus_influencias',$this->animo_max,true);
		$criteria->compare('bonus_dinero',$this->animo_max,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function actualizaRecursos($id_usuario)
	{
		try
		{
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
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			//throw $e;			
		}	
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

				}else if( ($columna==='influencias') && ($valor_nuevo >= $recursos->influencias_max))
						{
							$recursos->$columna=$recursos->influencias_max;

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