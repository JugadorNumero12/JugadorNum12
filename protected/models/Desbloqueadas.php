<?php

/**
 * Modelo de la tabla <<desbloqueadas>>
 *
 * columnas disponibles:
 * string $habilidades_id_habilidad
 * string $usuarios_id_usuario
 */
class Desbloqueadas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Desbloqueadas the static model class
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
		return 'desbloqueadas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('habilidades_id_habilidad, usuarios_id_usuario', 'required'),
			array('habilidades_id_habilidad, usuarios_id_usuario', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('habilidades_id_habilidad, usuarios_id_usuario', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <desbloqueadas - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* ALEX */
		return array( );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'habilidades_id_habilidad' => 'Habilidades Id Habilidad',
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
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

		$criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}