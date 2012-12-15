<?php

/**
 * Modelo de la tabla <<usuarios>>
 *
 * Columnas disponibles
 * 	string 	$id_usuario
 * 	string 	$equipos_id_equipo
 * 	string 	$nick
 * 	string 	$pass
 * 	string 	$email
 * 	integer $personaje
 * 	string 	$nivel
 */
class Usuarios extends CActiveRecord
{
	public $antigua_clave;
	public $nueva_clave1;
	public $nueva_clave2;
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
			array('nueva_clave1,nueva_clave2,antigua_clave','safe','on'=>'cambiarClave'),
			array('personaje', 'numerical', 'integerOnly'=>true),
			array('equipos_id_equipo, nivel', 'length', 'max'=>10),
			array('nick', 'length', 'max'=>45),
			array('pass, email', 'length', 'max'=>255),
			array('nueva_clave1,nueva_clave2,antigua_clave','required','on'=>'cambiarClave','message'=>'Tienes que rellenar estos campos'),
			array('antigua_clave', 'compare', 'compareAttribute'=>'pass','on'=>'cambiarClave','message'=>'Introduzca correctamente la contraseña actual'),
			array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'cambiarClave','message'=>'Deben coincidir las contraseñas'),
			array('nueva_clave1,nueva_clave2', 'compare', 'operator'=>'!=','compareAttribute'=>'antigua_clave','on'=>'cambiarClave','message'=>'Debe ser distinta a la contraseña actual'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_usuario, equipos_id_equipo, nick, pass, email, personaje, nivel', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <usuarios - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* ROBER */
		return array(
			/*Relacion entre <<usuarios>> y <<recursos>>*/
			'recursos'=>array(self::HAS_ONE, 'Recursos', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_individuales>>*/
            'accionesIndividuales'=>array(self::HAS_MANY, 'AccionesIndividuales', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<desbloqueadas>> */
			'desbloqueadas'=>array(self::HAS_MANY, 'Desbloqueadas', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_turno>> */
			'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<equipos>> */
			'equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo'),
			/*Relacion entre <<usuarios>> y <<participaciones>> */
			'participaciones'=>array(self::HAS_MANY, 'Participaciones', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_grupales>> */
			'accionesGrupales'=>array(self::HAS_MANY, 'AccionesGrupales', 'usuarios_id_usuario'),
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
