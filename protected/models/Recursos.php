<?php

/**
 * This is the model class for table "recursos".
 *
 * The followings are the available columns in table 'recursos':
 * @property string $usuarios_id_usuario
 * @property string $dinero
 * @property double $dinero_gen
 * @property string $influencias
 * @property string $influencias_max
 * @property double $influencias_gen
 * @property string $animo
 * @property string $animo_max
 * @property double $animo_gen
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
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen', 'required'),
			array('dinero_gen, influencias_gen, animo_gen', 'numerical'),
			array('usuarios_id_usuario, dinero, influencias, influencias_max, animo, animo_max', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, dinero, dinero_gen, influencias, influencias_max, influencias_gen, animo, animo_max, animo_gen', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <recursos - tabla>
	 *
	 * @return array relaciones.
	 */
	public function relations()
	{
		/* TODO indicar las relaciones dadas en el UML de la BD */
		return array(
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}