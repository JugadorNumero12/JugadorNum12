<?php

/**
 * This is the model class for table "clasificacion".
 *
 * The followings are the available columns in table 'clasificacion':
 * @property string $equipos_id_equipo
 * @property string $posicion
 * @property string $puntos
 * @property string $ganados
 * @property string $empatados
 * @property string $perdidos
 */
class Clasificacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Clasificacion the static model class
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
		return 'clasificacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos', 'required'),
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <clasificacion - tabla>
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
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'posicion' => 'Posicion',
			'puntos' => 'Puntos',
			'ganados' => 'Ganados',
			'empatados' => 'Empatados',
			'perdidos' => 'Perdidos',
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

		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('puntos',$this->puntos,true);
		$criteria->compare('ganados',$this->ganados,true);
		$criteria->compare('empatados',$this->empatados,true);
		$criteria->compare('perdidos',$this->perdidos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}