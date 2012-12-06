<?php

/**
 * Modelo de la tabla <<usuarios>>
 *
 * Columnas disponibles
 * @property string $id_usuario
 * @property string $equipos_id_equipo
 * @property string $nick
 * @property string $pass
 * @property string $email
 * @property integer $personaje
 * @property string $nivel
 */
class Usuarios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipos_id_equipo, nick, pass, email', 'required'),
			array('personaje', 'numerical', 'integerOnly'=>true),
			array('equipos_id_equipo, nivel', 'length', 'max'=>10),
			array('nick', 'length', 'max'=>45),
			array('pass, email', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_usuario, equipos_id_equipo, nick, pass, email, personaje, nivel', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <usuarios - tabla>
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
			'id_usuario' => 'Id Usuario',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'nick' => 'Nick',
			'pass' => 'Pass',
			'email' => 'Email',
			'personaje' => 'Personaje',
			'nivel' => 'Nivel',
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

		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('personaje',$this->personaje);
		$criteria->compare('nivel',$this->nivel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}