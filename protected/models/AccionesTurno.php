<?php

/**
 * Modelo para la tabla <<acciones_turno>>
 *
 * Columnas disponibles:
 * string  $usuarios_id_usuario
 * string  $habilidades_id_habilidad
 * string  $partidos_id_partido
 * string  $equipos_id_equipo
 * integer $turno
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
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo', 'required'),
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_turno - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* MARCOS */
		return array(
			//relacion con tablas de la arquitectura (1ª iteración)
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
			'partidos'=>array(self::BELONGS_TO, 'Partido', 'partidos_id_partido'),
			'equipos'=>array(self::BELONGS_TO, 'Equipo', 'equipos_id_equipo')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'partidos_id_partido' => 'Partidos Id Partido',
			'equipos_id_equipo' => 'Equipos Id Equipo',
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
		$criteria->compare('partidos_id_partido',$this->partidos_id_partido,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
