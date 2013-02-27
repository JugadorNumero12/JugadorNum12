<?php

/**
 * Modelo de la tabla <<partidos>>
 *
 * Columnas disponibles:
 * string $id_partido
 * string $equipos_id_equipo_1
 * string $equipos_id_equipo_2
 * string $hora
 * string $cronica
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
			array('equipos_id_equipo_1, equipos_id_equipo_2, hora', 'required'),
			array('equipos_id_equipo_1, equipos_id_equipo_2, ambiente, nivel_local, nivel_visitante, aforo_local, aforo_visitante, dif_niveles', 'length', 'max'=>10),
			array('hora, turno, goles_local, goles_visitante, moral_local, moral_visitante, ofensivo_local, ofensivo_visitante, defensivo_local, defensivo_visitante, estado', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_partido, equipos_id_equipo_1, equipos_id_equipo_2, hora, cronica, ambiente, nivel_local, nivel_visitante, aforo_local, aforo_visitante', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <partidos - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* SAM */
		return array(
			'esSiguiente'=>array(self::HAS_MANY, 'Equipos', 'partidos_id_partido'),
			'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'partidos_id_partido'),
			'local'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo_1'),
			'visitante'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo_2'),
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
		//TODO -> Regles de busqueda para atributos de turno??

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