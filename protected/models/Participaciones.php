<?php

/**
 * Modelo para la tabla <<participaciones>>
 *
 * Columnas disponibles:
 *  string $acciones_grupales_id_accion_grupal
 *  string $usuarios_id_usuario
 *  string $dinero_aportado
 *  string $influencias_aportadas
 *  string $animo_aportado
 */
class Participaciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Participaciones the static model class
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
		return 'participaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'required'),
			array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <participaciones - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* DANI */
		return array( );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'acciones_grupales_id_accion_grupal' => 'Acciones Grupales Id Accion Grupal',
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'dinero_aportado' => 'Dinero Aportado',
			'influencias_aportadas' => 'Influencias Aportadas',
			'animo_aportado' => 'Animo Aportado',
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

		$criteria->compare('acciones_grupales_id_accion_grupal',$this->acciones_grupales_id_accion_grupal,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('dinero_aportado',$this->dinero_aportado,true);
		$criteria->compare('influencias_aportadas',$this->influencias_aportadas,true);
		$criteria->compare('animo_aportado',$this->animo_aportado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}