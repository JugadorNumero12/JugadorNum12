<?php

/**
 * This is the model class for table "equipos".
 *
 * The followings are the available columns in table 'equipos':
 * @property string $id_equipo
 * @property string $nombre
 * @property string $categoria
 * @property string $aforo_max
 * @property string $aforo_base
 * @property integer $nivel_equipo
 * @property string $factor_ofensivo
 * @property string $factor_defensivo
 */
class Equipos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Equipos the static model class
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
		return 'equipos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, categoria, aforo_max, aforo_base, nivel_equipo, factor_ofensivo, factor_defensivo', 'required'),
			array('nivel_equipo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('categoria, aforo_max, aforo_base, factor_ofensivo, factor_defensivo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_equipo, nombre, categoria, aforo_max, aforo_base, nivel_equipo, factor_ofensivo, factor_defensivo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <equipos - tabla>
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
			'id_equipo' => 'Id Equipo',
			'nombre' => 'Nombre',
			'categoria' => 'Categoria',
			'aforo_max' => 'Aforo Max',
			'aforo_base' => 'Aforo Base',
			'nivel_equipo' => 'Nivel Equipo',
			'factor_ofensivo' => 'Factor Ofensivo',
			'factor_defensivo' => 'Factor Defensivo',
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

		$criteria->compare('id_equipo',$this->id_equipo,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('categoria',$this->categoria,true);
		$criteria->compare('aforo_max',$this->aforo_max,true);
		$criteria->compare('aforo_base',$this->aforo_base,true);
		$criteria->compare('nivel_equipo',$this->nivel_equipo);
		$criteria->compare('factor_ofensivo',$this->factor_ofensivo,true);
		$criteria->compare('factor_defensivo',$this->factor_defensivo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}