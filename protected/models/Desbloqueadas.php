<?php

/**
 * Modelo de la tabla desbloqueadas
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                    |
 * |:-------|:--------------------------|
 * | string | $habilidades_id_habilidad |
 * | string | $usuarios_id_usuario      |
 *
 *
 * @package modelos
 */
class Desbloqueadas extends CActiveRecord
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
        return 'desbloqueadas';
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
            array('habilidades_id_habilidad, usuarios_id_usuario', 'required'),
            array('habilidades_id_habilidad, usuarios_id_usuario', 'length', 'max'=>10),
            array('habilidades_id_habilidad, usuarios_id_usuario', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Define las relaciones entre la tabla desbloqueadas y el resto de tablas
     *
     * Relaciones definidas:
     * 
     * - usuarios
     * - habilidades
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre desbloqueadas - tabla
     */
    public function relations()
    {
        return array( 
            'usuarios'=>array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
            'habilidades'=>array(self::BELONGS_TO, 'Habilidades' , 'habilidades_id_habilidad'),
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
            'habilidades_id_habilidad' => 'Habilidades Id Habilidad',
            'usuarios_id_usuario' => 'Usuarios Id Usuario',
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
        $criteria=new CDbCriteria;

        $criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
        $criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria));
    }

}
