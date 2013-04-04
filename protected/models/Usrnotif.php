<?php

/**
 * Modelo de la tabla <<usrnotif>>
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
class Usrnotif extends CActiveRecord
{
	//public $nombre;
	//public $cont;
	//public $asun;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usrnotif the static model class
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
		return 'usrnotif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{ 	
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notificaciones_id_notificacion, usuarios_id_usuario', 'length', 'max'=>10),
			array('leido', 'length', 'max'=>1),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('notificaciones_id_notificacion, usuarios_id_usuario, leido', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <usrnotif - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		return array(
			/*Relacion entre <<usrnotif>> y <<notificaciones>>*/
			'notificaciones'=>array(self::BELONGS_TO, 'Notificaciones', 'notificaciones_id_notificacion'),
			/*Relacion entre <<usrnotif>> y <<usuarios>>*/
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
		 );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notificaciones_id_notificacion' => 'Id Notificacion',
			'usuarios_id_usuario' => 'Id Usuario',
			'leido' => 'Leido',
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

		$criteria->compare('notificaciones_id_notificacion',$this->notificaciones_id_notificacion,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('id_usuario_from',$this->id_usuario_from,true);
		$criteria->compare('leido',$this->leido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}