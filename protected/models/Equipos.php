<?php

/**
 * Modelo de la tabla equipos
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre             |
 * |:-------|:-------------------|
 * |string  | $id_equipo         |
 * |string  | $nombre            |
 * |string  | $categoria         |
 * |string  | $aforo_max         |
 * |string  | $aforo_base        |
 * |integer | $nivel_equipo      |
 * |string  | $factor_ofensivo   | 
 * |string  | $factor_defensivo  |
 *
 *
 * @package modelos
 */
class Equipos extends CActiveRecord
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
        return 'equipos';
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
            array('nombre, categoria, aforo_max, aforo_base, nivel_equipo, factor_ofensivo, factor_defensivo', 'required'),
            array('nivel_equipo', 'numerical', 'integerOnly'=>true),
            array('nombre', 'length', 'max'=>45),
            array('categoria, aforo_max, aforo_base, factor_ofensivo, factor_defensivo, partidos_id_partido', 'length', 'max'=>10),
            array('id_equipo, nombre, categoria, aforo_max, aforo_base, nivel_equipo, factor_ofensivo, factor_defensivo, partidos_id_partido', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Define las relaciones entre la tabla equipos y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - sigPartido
     * - local
     * - visitante
     * - clasificacion
     * - accionesTurno
     * - accionesGrupales
     * - usuarios
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre equipos - tabla
     */
    public function relations()
    {
        return array(
            'sigPartido'=>array(self::BELONGS_TO, 'Partidos', 'partidos_id_partido'),
            'local'=>array(self::HAS_MANY, 'Partidos', 'equipos_id_equipo_1'),
            'visitante'=>array(self::HAS_MANY, 'Partidos', 'equipos_id_equipo_2'),
            'clasificacion'=>array(self::HAS_ONE, 'Clasificacion', 'equipos_id_equipo'),
            'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'equipos_id_equipo'),
            'accionesGrupales'=>array(self::HAS_MANY, 'AccionesGrupales', 'equipos_id_equipo'),
            'usuarios'=>array(self::HAS_MANY, 'Usuarios', 'equipos_id_equipo'),
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
            'id_equipo' => 'Id Equipo',
            'nombre' => 'Nombre',
            'categoria' => 'Categoria',
            'aforo_max' => 'Aforo Max',
            'aforo_base' => 'Aforo Base',
            'nivel_equipo' => 'Nivel Equipo',
            'factor_ofensivo' => 'Factor Ofensivo',
            'factor_defensivo' => 'Factor Defensivo',
            'partidos_id_partido' => 'ID siguiente partido',
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

        $criteria->compare('id_equipo',$this->id_equipo,true);
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('categoria',$this->categoria,true);
        $criteria->compare('aforo_max',$this->aforo_max,true);
        $criteria->compare('aforo_base',$this->aforo_base,true);
        $criteria->compare('nivel_equipo',$this->nivel_equipo);
        $criteria->compare('factor_ofensivo',$this->factor_ofensivo,true);
        $criteria->compare('factor_defensivo',$this->factor_defensivo,true);
        $criteria->compare('partidos_id_partido',$this->factor_defensivo,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria));
    }

    /** Funcion auxiliar que modifica la tabla de equipos
     * 
     * @paremetro equipo al que modificamos sus recursos
     * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
     * @parametro cantidad de recursos que aumentamos
     * @devuelve flag de error
     * @ejemplo Recursos::aumentar_recursos(3, "animo", 30);
     */
    public static function aumentar_recursos_equipo($id_equipo, $columna, $cantidad)
    {
        /* ROBER */
        /*Recupero el usuario del que voy a aumentar los recursos*/
        $equipo=Equipos::model()->findByPK($id_equipo);

        //Comprobación de seguridad
        if ($equipo === null)
        {
            throw new CHttpException(404,"Equipo no encontrado. (aumentar_recursos_equipo,Helper.php)");
            
        }
    
        /*Cojo la columna a modificar del modelo, para modificarla despues*/
        $actuales=$equipo->$columna;
        $valor_nuevo=$actuales + $cantidad;
        /*Debo comprobar que no esta o sobrepasa en su máximo el atributo*/

        /*En el caso del animo*/
        if( ($columna==='aforo_base') && ($valor_nuevo >= $equipo->aforo_max))
        {
            $equipo->$columna=$equipo->aforo_max;

        }
        else
        {
            $equipo->$columna=$valor_nuevo;
        }
        
        /*Si save() no lanza error entonces se realizo correctamente la actualizacion
         sino devuelves error*/
        if($equipo->save())
        {
            return 0;

        }else
            {
                return -1;
            }
            
        
    }

}
