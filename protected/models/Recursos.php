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
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen, bonus_dinero, bonus_influencias, bonus_animo', 'required'),
			array('dinero_gen, influencias_gen, animo_gen', 'numerical'),
			array('usuarios_id_usuario, dinero, influencias, influencias_max, animo, animo_max, bonus_dinero, bonus_influencias, bonus_animo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen', 'safe', 'on'=>'search'),
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
		Yii::import('application.components.Helper');

		try
		{
			$helper = new Helper();

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
				if ($rec->ultima_act == 0)
				{
					$rec->ultima_act = time();
				}
				else
				{
					$rec->ultima_act + ($dif_minutos*60);
				}

				if (!$rec->save())
					throw new Exception("Imposible guardar modelo de recursos. (actualizaRecursos,RecusosModel)", 500);					

				//influencias
				$helper->aumentar_recursos($rec->usuarios_id_usuario, "influencias", $influencias_nuevas);
				//dinero
				$helper->aumentar_recursos($rec->usuarios_id_usuario, "dinero", $dinero_nuevo);
				//animo
				$helper->aumentar_recursos($rec->usuarios_id_usuario, "animo", $animo_nuevo);
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
}