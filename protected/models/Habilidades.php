<?php

/**
 * Modelo de la tabla <<habilidades>>
 *
 * Columnas disponibles:
 * string $id_habilidad
 * string $codigo
 */
class Habilidades extends CActiveRecord
{
	const TIPO_GRUPAL = 0;
	const TIPO_INDIVIDUAL = 1;
	const TIPO_PARTIDO = 2;
	const TIPO_PASIVA = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidades the static model class
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
		return 'habilidades';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, tipo, nombre, descripcion, dinero, animo, influencias, participantes_max', 'required'),
			array('codigo, dinero, animo, influencias, participantes_max, dinero_max, animo_max, influencias_max, cooldown_fin', 'length', 'max'=>10),
			array('dinero', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_habilidad, codigo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <habilidades - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* ARTURO */
		return array(
			//Relación entre "habilidades" y "desbloqueadas"
			'desbloqueadas' => array(self::HAS_MANY, 'Desbloqueadas', 'habilidades_id_habilidad'),
			//Relación entre "habilidades" y "acciones_individuales"
			'accionesIndividuales' => array(self::HAS_MANY, 'AccionesIndividuales', 'habilidades_id_habilidad'),
			//Relación entre "habilidades" y "acciones_grupales"
			'accionesGrupales' => array(self::HAS_MANY, 'AccionesGrupales', 'habilidades_id_habilidad'),
			//Relación entre "habilidades" y "acciones_turno"
			//'accionesTurno' => array(self::HAS_MANY, 'AccionesTurno', 'habilidades_id_habilidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_habilidad' => 'ID',
			'codigo' => 'Codigo',
			'tipo' => 'Tipo',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripci&oacute;n',
			'dinero' => 'Dinero',
			'animo' => '&Aacute;nimo',
			'influencias' => 'Influencia',
			'dinero_max' => 'Dinero MAX',
			'animo_max' => '&Aacute;nimo MAX',
			'influencias_max' => 'Influencia MAX',
			'participantes_max' => 'Participantes m&aacute;ximos',
			'cooldown_fin' => 'Cooldown/Fin'
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

		//TDOD -> Añadir resto de campos en search()??

		$criteria=new CDbCriteria;

		$criteria->compare('id_habilidad',$this->id_habilidad,true);
		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}