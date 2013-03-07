<?php

/**
 * Modelo de la tabla <<emails>>
 *
 * Columnas disponibles
 * string 	$id_email
 * string 	$id_usuario_to
 * string 	$id_usuario_from
 * string 	$fecha
 * string 	$contenido
 * string	$leido
 * string 	$asunto
 * string 	$borrado_to
 * string 	$borrado_from
 */
class Emails extends CActiveRecord
{
	public $nombre;
	//public $cont;
	//public $asun;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Emails the static model class
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
		return 'emails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{ 	
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario_to, id_usuario_from, fecha, contenido, leido, asunto,borrado_to,borrado_from', 'required'),
			array('asunto', 'length', 'max'=>50),
			array('id_email, id_usuario_to, id_usuario_from', 'length', 'max'=>10),
			array('leido,borrado_to,borrado_from', 'length', 'max'=>1),
			array('fecha', 'length', 'max'=>19),

			/*Validaciones para redactar email*/
			array('nombre,contenido,asunto','required','on'=>'redactar','message'=>'Tienes que rellenar estos campos'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_email, id_usuario_to, id_usuario_from, fecha, contenido, leido, asunto,borrado_to,borrado_from', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <emails - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		return array(
			/*Relacion entre <<emails>> y <<usuarios>>*/
			'usuarioTo'=>array(self::BELONGS_TO, 'Usuarios', 'id_usuario_to'),
			/*Relacion entre <<emails>> y <<usuarios>>*/
			'usuarioFor'=>array(self::BELONGS_TO, 'Usuarios', 'id_usuario_from'),
		 );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_email' => 'Id Email',
			'id_usuario_to' => 'Id Usuario Para',
			'id_usuario_from' => 'Id Usuario De',
			'fecha' => 'Fecha',
			'contenido' => 'Contenido',
			'leido' => 'Leido',
			'asunto' => 'Asunto',
			'borrado_to' => 'Borrado To'
			'borrado_from' => 'Borrado From'
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

		$criteria->compare('id_email',$this->id_email,true);
		$criteria->compare('id_usuario_to',$this->id_usuario_to,true);
		$criteria->compare('id_usuario_from',$this->id_usuario_from,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('leido',$this->leido);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('borrado_to',$this->borrado_to,true);
		$criteria->compare('borrado_from',$this->borrado_from,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}