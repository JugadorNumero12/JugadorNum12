<?php

/**
 * Modelo para la tabla ```participaciones```
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                                |
 * |:-------|:--------------------------------------|
 * | string | $acciones_grupales_id_accion_grupal   |
 * | string | $usuarios_id_usuario                  |
 * | string | $dinero_aportado                      |
 * | string | $influencias_aportadas                |
 * | string | $animo_aportado                       |
 *
 * @package modelos
 */
class Participaciones extends CActiveRecord
{
    /** @type double    recurso dinero */
    public $dinero_nuevo;
    /** @type double    recurso animo */
    public $animo_nuevo;
    /** @type double    recurso influencia */
    public $influencia_nueva;

    /**
     * Devuelve el modelo estatico de la clase ```active record``` especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase ```active record```
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
        return 'participaciones';
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
            array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'required'),
            array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'length', 'max'=>10),
            array('acciones_grupales_id_accion_grupal, usuarios_id_usuario, dinero_aportado, influencias_aportadas, animo_aportado', 'safe', 'on'=>'search'),
            array('dinero_nuevo, animo_nuevo, influencia_nueva', 'required', 'message'=>'Todos los campos deben tener un valor fijado.', 'on'=>'participar'),
            array('dinero_nuevo', 'numerical', 'integerOnly'=>true, 'min'=>0, 'message'=>'El campo Dinero debe ser un numero >= 0', 'on'=>'participar'),            
            array('animo_nuevo', 'numerical', 'integerOnly'=>true, 'min'=>0, 'message'=>'El campo Animo debe ser un numero >= 0', 'on'=>'participar'),
            array('influencia_nueva', 'numerical', 'integerOnly'=>true, 'min'=>0, 'message'=>'El campo Influencia debe ser un numero >= 0', 'on'=>'participar'),
        );
    }

    /**
     * Define las relaciones entre la tabla ```participaciones``` y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - usuario
     * - accionGrupal
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre ```participaciones``` - ```tabla```
     */
    public function relations()
    {
        return array(
            'usuario' => array( self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario'),
            'accionGrupal' => array( self::BELONGS_TO, 'AccionesGrupales', 'acciones_grupales_id_accion_grupal'),
        );
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
            'acciones_grupales_id_accion_grupal' => 'Acciones Grupales Id Accion Grupal',
            'usuarios_id_usuario' => 'Usuarios Id Usuario',
            'dinero_aportado' => 'Dinero Aportado',
            'influencias_aportadas' => 'Influencias Aportadas',
            'animo_aportado' => 'Animo Aportado',
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

        $criteria->compare('acciones_grupales_id_accion_grupal',$this->acciones_grupales_id_accion_grupal,true);
        $criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
        $criteria->compare('dinero_aportado',$this->dinero_aportado,true);
        $criteria->compare('influencias_aportadas',$this->influencias_aportadas,true);
        $criteria->compare('animo_aportado',$this->animo_aportado,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria));
    }

}
