<?php

/**
 * This is the model class for table "partidos".
 *
 * The followings are the available columns in table 'partidos':
 * @property string $id_partido
 * @property string $equipos_id_equipo_1
 * @property string $equipos_id_equipo_2
 * @property string $hora
 * @property string $cronica
 */
class Partidos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partidos the static model class
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
		return 'partidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipos_id_equipo_1, equipos_id_equipo_2, hora, cronica', 'required'),
			array('equipos_id_equipo_1, equipos_id_equipo_2', 'length', 'max'=>10),
			array('hora', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_partido, equipos_id_equipo_1, equipos_id_equipo_2, hora, cronica', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_partido' => 'Id Partido',
			'equipos_id_equipo_1' => 'Equipos Id Equipo 1',
			'equipos_id_equipo_2' => 'Equipos Id Equipo 2',
			'hora' => 'Hora',
			'cronica' => 'Cronica',
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

		$criteria->compare('id_partido',$this->id_partido,true);
		$criteria->compare('equipos_id_equipo_1',$this->equipos_id_equipo_1,true);
		$criteria->compare('equipos_id_equipo_2',$this->equipos_id_equipo_2,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('cronica',$this->cronica,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}