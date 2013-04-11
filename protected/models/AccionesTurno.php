<?php

/**
 * Modelo para la tabla <<acciones_turno>>
 *
 * Columnas disponibles:
 * string  $usuarios_id_usuario
 * string  $habilidades_id_habilidad
 * string  $partidos_id_partido
 * string  $equipos_id_equipo
 * integer $turno
 */
class AccionesTurno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionesTurno the static model class
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
		return 'acciones_turno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo, influencias_acc', 'required'),
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo, influencias_acc', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usuarios_id_usuario, partidos_id_partido, equipos_id_equipo, influencias_acc', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_turno - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* MARCOS */
		return array(
			//relacion con tablas de la arquitectura (1ª iteración)
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
			'partidos'=>array(self::BELONGS_TO, 'Partido', 'partidos_id_partido'),
			'equipos'=>array(self::BELONGS_TO, 'Equipo', 'equipos_id_equipo')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usuarios_id_usuario' => 'Usuarios Id Usuario',
			'partidos_id_partido' => 'Partidos Id Partido',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'influencias_acc' => 'Influencias acumuladas',
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

		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('partidos_id_partido',$this->partidos_id_partido,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('influencias_acc',$this->equipos_id_equipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// Busca participacion en la tabla acciones turno
	public function buscarParticipacion($id_usuario, $id_partido,$id_equipo)
	{
		 $participacion =Participaciones::model()->findAllByAttributes(array('usuarios_id_usuario'=> $id_usuario ,
																			'partidos_id_partido'=> $id_partido,
																			'equipos_id_equipo'=> $id_equipo));

		return $participacion; 
	}

	public function agregarParticipacion($id_usuario, $id_partido,$id_equipo)
	{
		 $modelo=new AccionesTurno();
		 $modelo->setAttributes(array('usuarios_id_usuario'=> $id_usuario ,
										'partidos_id_partido'=> $id_partido,
										'equipos_id_equipo'=> $id_equipo,
										'influencias_acc'=> 0));
	}

	//incorpora registro en la tabla acciones turno si el usuario aun no estaba
	public static function incorporarAccion($id_usuario, $id_partido,$id_equipo)
	{
		 // Busco si ha Participado ya ese usuario en en ese partido
		$participante = buscarParticipacion($id_usuario, $id_partido,$id_equipo) ;

		if($participante  === null)
		{
			agregarParticipacion($id_usuario, $id_partido,$id_equipo);

		}
                
	}																	'
}
