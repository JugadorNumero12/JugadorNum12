<?php

/**
 * Modelo para la tabla <<clasificacion>>
 *
 * Columnas disponibles:
 * - string $equipos_id_equipo
 * - string $posicion
 * - string $puntos
 * - string $ganados
 * - string $empatados
 * - string $perdidos
 *
 * @package protected\models\Clasificacion
 */
class Clasificacion extends CActiveRecord
{
    /**
     * Devuelve el modelo estatico de la clase "active record" especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase "active record"
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
		return 'clasificacion';
	}

    /**
     * Define las reglas definidas para los atributos del modelo, incluida la regla usada por "search()"
     * Deben definirse solo las reglas para aquellos atributos que reciban entrada del usuario
     *
     * > Funcion predeterminada de Yii
     *
     * @return string[]     reglas de validacion para los atributos
     */
	public function rules()
	{
        return array(
            array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'required'),
            array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'length', 'max'=>10),
            array('equipos_id_equipo, posicion, puntos, ganados, empatados, perdidos, diferencia_goles', 'safe', 'on'=>'search'),
        );
	}

    /**
     * Define las relaciones entre la tabla ```clasificacion``` y el resto de tablas
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre ```Clasificacion``` - ```tabla```
     */
	public function relations()
	{
		return array('equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo') );
	}

    /**
     * Define los nombres _completos_ de los atributos
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     nombres de los atributos 
     */
	public function attributeLabels()
	{
		return array(
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'posicion' => 'Posicion',
			'puntos' => 'Puntos',
			'ganados' => 'Ganados',
			'empatados' => 'Empatados',
			'perdidos' => 'Perdidos',
			'diferencia_goles' => 'Diferencia de goles',
		);
	}

    /**
     * Devuelve la lista de modelos con las condiciones de busqueda/filtro
     *
     *
     * > Funcion predeterminada de Yii
     *
     * @return \CActiveDataProvider[]   criterio definido para las busquedas-filtros
     */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('puntos',$this->puntos,true);
		$criteria->compare('ganados',$this->ganados,true);
		$criteria->compare('empatados',$this->empatados,true);
		$criteria->compare('perdidos',$this->perdidos,true);
		$criteria->compare('diferencia_goles',$this->perdidos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
