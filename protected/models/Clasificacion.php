<?php

/**
 * Modelo para la tabla <<clasificacion>>
 *
 * Columnas disponibles:
 * 	string $equipos_id_equipo
 * 	string $posicion
 * 	string $puntos
 * 	string $ganados
 * 	string $empatados
 * 	string $perdidos
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
		return '{{clasificacion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'required'),
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <clasificacion - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* MARCOS */
		return array(
			//relacion con tablas de la arquitectura (1ª iteración)
			'equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo')
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
			'diferencia_goles' => 'Diferencia de goles',
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
		$criteria->compare('diferencia_goles',$this->perdidos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
