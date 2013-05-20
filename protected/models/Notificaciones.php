<?php

/**
 * Modelo de la tabla <<notificaciones>>
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre             |
 * |:-------|:-------------------|
 * | string | $id_notificacion   |
 * | string | $fecha             |
 * | string | $mensaje           |
 * | string | $imagen            |
 *
 *
 * @package modelos
 */
class Notificaciones extends CActiveRecord
{
	/**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
     * @return \Notificaciones    el modelo estatico de la clase
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
		return 'notificaciones';
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
			array('id_notificacion', 'length', 'max'=>10),
			array('imagen', 'length', 'max'=>70),
			array('fecha', 'length', 'max'=>11),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_notificacion, equipos_id_equipo, imagen,  fecha', 'safe', 'on'=>'search'),
		);
	}

	/**
     * Define las relaciones entre la tabla notificaciones y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - usrnotif
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre notificaciones - tabla
     */
	public function relations()
	{
		return array(
			/*Relacion entre <<usrnotif>> y <<notificaciones>>*/
			'usrnotif'=>array(self::HAS_MANY, 'Usrnotif', 'notificaciones_id_notificacion'),
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
			'id_notificacion' => 'Id Notificacion',
			'equipos_id_equipo' => 'Id Equipo',
			'fecha' => 'Fecha',
			'mensaje' => 'Mensaje',
			'imagen' => 'imagen',
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

		$criteria->compare('id_notificacion',$this->id_notificacion,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('imagen',$this->imagen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
     * Elimina las notificaciones existentes
     *
     * @return void
	 */
	public static function borrarNotificaciones(){
		//Borramos conexiones de notificaciones leidas
		Usrnotif::model()->deleteAllByAttributes(array('leido'=>1)); 
		//Cogemos todas las notificaciones
		$notificaciones = Notificaciones::model()->findAll();
		foreach($notificaciones as $notificacion){
			//si a alguna de las notificaciones ha sido leida por todos los usuarios se borra
			$u = Usrnotif::model()->findByAttributes(array('notificaciones_id_notificacion'=>$notificacion->id_notificacion));
			if($u === null)$notificacion->delete();
		}
	}
		
}