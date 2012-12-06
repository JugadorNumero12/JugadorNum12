<?php

/**
 * This is the model class for table "acciones_turno".
 *
 * The followings are the available columns in table 'acciones_turno':
 * @property string $usuarios_id_usuario
 * @property string $habilidades_id_habilidad
 * @property string $partidos_id_partido
 * @property string $equipos_id_equipo
 * @property integer $turno
 */
class AccionesTurno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionesTurno the static model class
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
		return 'acciones_turno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id_usuario, habilidades_id_habilidad, partidos_id_partido, equipos_id_equipo, turno', 'required'),
			array('turno', 'numerical', 'integerOnly'=>true),
			array('usuarios_id_usuario, habilidades_id_habilidad, partidos_id_partido, equipos_id_equipo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, habilidades_id_habilidad, partidos_id_partido, equipos_id_equipo, turno', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_turno - tabla>
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
			'habilidades_id_habilidad' => 'Habilidades Id Habilidad',
			'partidos_id_partido' => 'Partidos Id Partido',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'turno' => 'Turno',
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
		$criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
		$criteria->compare('partidos_id_partido',$this->partidos_id_partido,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('turno',$this->turno);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}