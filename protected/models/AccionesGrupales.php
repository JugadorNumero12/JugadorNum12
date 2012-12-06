<?php

/**
 * This is the model class for table "acciones_grupales".
 *
 * The followings are the available columns in table 'acciones_grupales':
 * @property string $id_accion_grupal
 * @property string $usuarios_id_usuario
 * @property string $habilidades_id_habilidad
 * @property string $equipos_id_equipo
 * @property string $influencias_acc
 * @property string $animo_acc
 * @property string $dinero_acc
 * @property string $jugadores_acc
 * @property string $finalizacion
 */
class AccionesGrupales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionesGrupales the static model class
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
		return 'acciones_grupales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc, finalizacion', 'required'),
			array('usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc', 'length', 'max'=>10),
			array('finalizacion', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_accion_grupal, usuarios_id_usuario, habilidades_id_habilidad, equipos_id_equipo, influencias_acc, animo_acc, dinero_acc, jugadores_acc, finalizacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_grupales - tabla>
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
			'id_accion_grupal' => 'Id Accion Grupal',
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'habilidades_id_habilidad' => 'Habilidades Id Habilidad',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'influencias_acc' => 'Influencias Acc',
			'animo_acc' => 'Animo Acc',
			'dinero_acc' => 'Dinero Acc',
			'jugadores_acc' => 'Jugadores Acc',
			'finalizacion' => 'Finalizacion',
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

		$criteria->compare('id_accion_grupal',$this->id_accion_grupal,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('influencias_acc',$this->influencias_acc,true);
		$criteria->compare('animo_acc',$this->animo_acc,true);
		$criteria->compare('dinero_acc',$this->dinero_acc,true);
		$criteria->compare('jugadores_acc',$this->jugadores_acc,true);
		$criteria->compare('finalizacion',$this->finalizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}