<?php

/**
 * Modelo de la tabla usrnotif
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                    |
 * |:-------|:--------------------------|
 * | string | $id_email                 |
 * | string | $id_usuario_to            |
 * | string | $id_usuario_from          |
 * | string | $fecha                    |
 * | string | $contenido                |
 * | string | $leido                    |
 * | string | $asunto                   |
 * | string | $borrado_to               |
 * | string | $borrado_from             |
 */
class Usrnotif extends CActiveRecord
{
    /**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
     * @return \AccionesGrupales    el modelo estatico de la clase
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
		return 'usrnotif';
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
        return array(
            array('notificaciones_id_notificacion, usuarios_id_usuario', 'length', 'max'=>10),
            array('leido', 'length', 'max'=>1),
            array('notificaciones_id_notificacion, usuarios_id_usuario, leido', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Define las relaciones entre la tabla usuarios y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - notificaciones
     * - usuarios
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre usrnotif - tabla
     */
	public function relations()
	{
		return array(
			'notificaciones'=>array(self::BELONGS_TO, 'Notificaciones', 'notificaciones_id_notificacion'),
			'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
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
			'notificaciones_id_notificacion' => 'Id Notificacion',
			'usuarios_id_usuario' => 'Id Usuario',
			'leido' => 'Leido',
		);
	}

    /**
     * Devuelve la lista de modelos con las condiciones de busqueda/filtro
     *
     * Atributos no contemplados para la busqueda
     *
     * - fecha
     * - contenido
     * - asunto
     * - borrado_to
     * - borrado_from
     *
     * > Funcion predeterminada de Yii
     *
     * @return \CActiveDataProvider[]   criterio definidos para las busquedas
     */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('notificaciones_id_notificacion',$this->notificaciones_id_notificacion,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('id_usuario_from',$this->id_usuario_from,true);
		$criteria->compare('leido',$this->leido);

		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}

}
