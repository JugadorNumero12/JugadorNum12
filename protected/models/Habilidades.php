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
	const TIPO_INDIVIDUAL = 'individual';
	const TIPO_GRUPAL = 'grupal';

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
			array('codigo', 'required'),
			array('codigo', 'length', 'max'=>10),
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
		return array( );
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

		$criteria=new CDbCriteria;

		$criteria->compare('id_habilidad',$this->id_habilidad,true);
		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}