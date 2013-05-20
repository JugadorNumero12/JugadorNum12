<?php

/**
 * Modelo para la tabla <<acciones_turno>>
 *
 * Columnas disponibles:
 *
 * | tipo    | nombre                    |
 * | :------ | :------------------------ |
 * | string  | $usuarios_id_usuario      |
 * | string  | $habilidades_id_habilidad |
 * | string  | $partidos_id_partido      |
 * | string  | $equipos_id_equipo        |
 * | integer | $turno                    |
 *
 * @package modelos
 */
class AccionesTurno extends CActiveRecord
{
	    /**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
	 * @return \AccionesTurno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * Devuelve el nombre de la tabla asociada a la clase
     *
     * > Funcion predeterminada de Yii
     * 
     * @return string   nombre de la tabla en la base de datos
     */
	public function tableName()
	{
		return 'acciones_turno';
	}

	/**
     * Define las reglas definidas para los atributos del modelo.
     *
     * Incluye la regla usada por la funcion ```search()```
     * Deben definirse solo las reglas para aquellos atributos que reciban entrada del usuario
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     reglas de validacion para los atributos
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
	 * Relaciones definidas:
     *
     * - usuarios
     * - partidos
     * - equipos
     *
	 * > Funcion predeterminada de Yii
	 *
	 * @return array de relaciones
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
     * Define los nombres completos de los atributos
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     nombres de los atributos 
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
     * Devuelve la lista de modelos con las condiciones de busqueda/filtro
     *
     * > Funcion predeterminada de Yii
     *
     * @return \CActiveDataProvider[]   criterio definidos para las busquedas
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

	/**
	 * Busca participacion en la tabla acciones turno
	 * 
	 * @param int $id_usuario   id del usuario
	 * @param int $id_partido   id del partido
	 * @param int $id_equipo    id del equipo
	 * @return $participacion
	 */
	public static function buscarParticipacion($id_usuario, $id_partido,$id_equipo)
	{
		 
		$participacion = AccionesTurno::model()->findByAttributes(array('usuarios_id_usuario'=> $id_usuario ,
																			'partidos_id_partido'=> $id_partido,
																			'equipos_id_equipo'=> $id_equipo));

		
		return $participacion; 
	}

	/**
	 * Agrega participacion en la tabla acciones turno
	 * 
	 * @param int $id_usuario   id del usuario
	 * @param int $id_partido   id del partido
	 * @param int $id_equipo    id del equipo
	 * @return void
	 */
	public static  function agregarParticipacion($id_usuario, $id_partido,$id_equipo)
	{
		 $modelo=new AccionesTurno();
		 $modelo->setAttributes(array('usuarios_id_usuario'=> $id_usuario ,
										'partidos_id_partido'=> $id_partido,
										'equipos_id_equipo'=> $id_equipo,
										'influencias_acc'=> 0));

		 $modelo->save();
	}

	/**
	 * incorpora registro en la tabla acciones turno si el usuario aun no estaba
	 *
	 * @param int $id_usuario   id del usuario
	 * @param int $id_partido   id del partido
	 * @param int $id_equipo    id del equipo
	 * @return void
	 */
	public static function incorporarAccion($id_usuario, $id_partido,$id_equipo)
	{

		 // Busco si ha Participado ya ese usuario en en ese partido
		$participante = AccionesTurno::buscarParticipacion($id_usuario, $id_partido,$id_equipo);

		
		if($participante  === null)
		{
			
			AccionesTurno::agregarParticipacion($id_usuario, $id_partido,$id_equipo);

		}
                
	}	

    /**
	 * Suma una cantidad de influencias a una participacion
	 *
	 * @param $participacion
	 * @param int $cantidad
	 * @return void
	 */
	public static function sumarInfluencia($participacion,$cantidad)
	{
		$influenciasAcc=$participacion->influencias_acc;
		$participacion->setAttributes(array('influencias_acc'=> $influenciasAcc + $cantidad));
		$participacion->save();

	}

	/**
	 * Usar accion en el partido
	 *
	 * Incorpora la accion, busca la participacion y suma influencia a la accion y
	 * 
	 * @param $participacion
	 * @param int $cantidad
	 * @return void
	 */
	public static function usarPartido($id_usuario,$id_equipo,$id_partido,$habilidad,$res)
	{
		// Importar acciones
		Yii::import('application.components.Acciones.*');

		// Restar recursos
		$res['dinero'] 		-= $habilidad['dinero'];
		$res['animo']  		-= $habilidad['animo'];
		$res['influencias'] -= $habilidad['influencias'];
		$res['influencias_partido_bloqueadas'] += $habilidad['influencias']; 
		$res->save();

		//Incorporo la accion si ese usuario aun no ha participado
		AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);

		$participacion=AccionesTurno::buscarParticipacion($id_usuario, $id_partido,$id_equipo);

		//Sumo la influencia de esta accion a la que tenga acumulada
		AccionesTurno::sumarInfluencia($participacion,$habilidad->influencias);

		//Tomar nombre de habilidad para instanciación dinámica	
    	$nombreHabilidad = $habilidad->codigo;
    	 //echo '<pre>'.die(var_dump($id_partido)).'</pre>' ; 
    	//Llamar al singleton correspondiente y ejecutar dicha acción
    	$nombreHabilidad::getInstance()->ejecutar($id_usuario,$id_partido,$id_equipo);	
	}																
}
