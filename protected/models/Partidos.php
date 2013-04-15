<?php

/**
 * Modelo de la tabla partidos
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                            |
 * |:-------|:----------------------------------|
 * | string | $id_partido                       |
 * | string | $equipos_id_equipo_1              |
 * | string | $equipos_id_equipo_2              |
 * | object | $hora                             |
 * | string | $cronica                          |
 *
 *
 * @package modelos
 */
class Partidos extends CActiveRecord
{
    /** 
     * Facilita cambiar los factores de partido 
     *
     * @type object[]  
     */
    public static $datos_factores = array ( 
        //Si es local
        'local' => array (
            'ambiente'=> 'ambiente',
            'nivel'=> 'nivel_local',
            'aforo' => 'aforo_local',
            'moral' => 'moral_local',
            'ofensivo' => 'ofensivo_local',
            'defensivo' => 'defensivo_local'
        ), 
        //Si es visitante
        'visitante' => array (
            'ambiente'=> 'ambiente',
            'nivel'=> 'nivel_visitante',
            'aforo' => 'aforo_visitante',
            'moral' => 'moral_visitante',
            'ofensivo' => 'ofensivo_visitante',
            'defensivo' => 'defensivo_visitante'
        ), 
    );

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
        return 'partidos';
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
            array('equipos_id_equipo_1, equipos_id_equipo_2, hora', 'required'),
            array('equipos_id_equipo_1, equipos_id_equipo_2, ambiente, nivel_local, nivel_visitante, aforo_local, aforo_visitante, dif_niveles', 'length', 'max'=>10),
            array('hora, turno, goles_local, goles_visitante, moral_local, moral_visitante, ofensivo_local, ofensivo_visitante, defensivo_local, defensivo_visitante, estado', 'length', 'max'=>11),
            array('id_partido, equipos_id_equipo_1, equipos_id_equipo_2, hora, cronica, ambiente, nivel_local, nivel_visitante, aforo_local, aforo_visitante', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Define las relaciones entre la tabla partidos y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - esSiguiente
     * - accionesTurno
     * - local
     * - visitante
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre partidos - tabla
     */
    public function relations()
    {
        return array(
            'esSiguiente'=>array(self::HAS_MANY, 'Equipos', 'partidos_id_partido'),
            'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'partidos_id_partido'),
            'local'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo_1'),
            'visitante'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo_2'),
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
            'id_partido' => 'Id Partido',
            'equipos_id_equipo_1' => 'Equipos Id Equipo 1',
            'equipos_id_equipo_2' => 'Equipos Id Equipo 2',
            'hora' => 'Hora',
            'cronica' => 'Cronica',
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

        $criteria->compare('id_partido',$this->id_partido,true);
        $criteria->compare('equipos_id_equipo_1',$this->equipos_id_equipo_1,true);
        $criteria->compare('equipos_id_equipo_2',$this->equipos_id_equipo_2,true);
        $criteria->compare('hora',$this->hora,true);
        $criteria->compare('cronica',$this->cronica,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria));
    }


    /** 
     * Funcion auxiliar que modifica los factores de un partido: aumenta el factor espeficicado
     * 
     * @static
     *
     * @param int $id_partido   partido en el que modificamos los factores
     * @param int $id_equipo    equipo sobre el que se aplica la modificacion
     * @param string $columna   columna de la tabla sobre la que modificamos (moral, ambiente, f_ofensivo...)
     * @param double $cantidad  cantidad que modificamos 
     *
     * @throws \CHttpException  partido no encontrado
     *
     * @return int              flag de error (0 si no ha habido ningun error; -1 cc)
     */
    public static function aumentar_factores($id_partido, $id_equipo, $columna, $cantidad)
    {
        // buscar el partido
        $partido=Partidos::model()->findByPK($id_partido);
        if ($partido === null) {
            // comprobación de seguridad
            throw new CHttpException(404,"Partido no encontrado. (aumentar_factores,Helper.php)");
        }

        // equipo juego de local o de visitante
        if($partido->equipos_id_equipo_1 == $id_equipo) {
            $factor=self::$datos_factores['local'][$columna];
            $valor_nuevo=$partido->$factor + $cantidad;

            //Si fallara tiene que ser por el $factor,comprobar si es asi 
            $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
            
            if ($partido->save()) {
                return 0;
            } else { 
                return -1;
            }
        } else if ($partido->equipos_id_equipo_2 == $id_equipo) {
            $factor=self::$datos_factores['visitante'][$columna];
            $valor_nuevo=$partido->$factor + $cantidad;
            
            //Si fallara tiene que ser por el $factor,comprobar si es asi 
            $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
            
            if ($partido->save()) {
                return 0; 
            } else { 
                return -1;
            }       
        } else {
            //Si ha llegado aqui por alguna cosa, es que no coincide con ninguno de 
            //los id de los equipo del partido
            return -1;
        }
    }

    /** 
     * Funcion auxiliar que modifica los factores de un partido: disminuye el factor espeficicado
     * 
     * @static 
     *
     * @param int $id_partido   partido en el que modificamos los factores
     * @param int $id_equipo    equipo sobre el que se aplica la modificacion
     * @param string $columna   columna de la tabla sobre la que modificamos (moral, ambiente, f_ofensivo...)
     * @param double $cantidad  cantidad que modificamos 
     *
     * @throws \CHttpException  partido no encontrado
     *
     * @return int              flag de error (0 si no ha habido ningun error ; -1 cc)
     */
    public static function disminuir_factores($id_partido, $id_equipo, $columna, $cantidad)
    {
        // buscar el partido
        $partido=Partidos::model()->findByPK($id_partido);
        if ($partido === null) {
            //Comprobación de seguridad
            throw new CHttpException(404,"Partido no encontrado. (disminuir_factores,Helper.php)");
        }

        // equipo juega de local o visitante 
        if($partido->equipos_id_equipo_1 == $id_equipo) {
            $factor=self::$datos_factores['local'][$columna];
            $valor_nuevo=$partido->$factor - $cantidad;

            //Si fallara tiene que ser por el $factor,comprobar si es asi 
            $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
            
            if ($partido->save()) {
                return 0;
            } else { 
                return -1;
            }
        } else if ($partido->equipos_id_equipo_2 == $id_equipo) {
            $factor=self::$datos_factores['visitante'][$columna];
            $valor_nuevo=$partido->$factor - $cantidad;
            
            //Si fallara tiene que ser por el $factor,comprobar si es asi 
            $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
            
            if ($partido->save()) {
                return 0; 
            } else {
                return -1;
            }
        } else {
            //Si ha llegado aqui por alguna cosa, es que no coincide con ninguno de 
            //los id de los equipo del partido
            return -1;
        }
    }


    /** 
     * Funcion auxiliar que modifica la tabla de partidos de forma proporcionada
     * 
     * @static 
     *
     * @param int $id_partido       partido en el que modificamos los factores
     * @param int $id_equipo        equipo sobre el que se aplica la modificacion
     * @param string $columna       columna de la tabla sobre la que modificamos (moral, ambiente, f_ofensivo...)
     * @param double $proporcion    proporcion que modificamos 
     *
     * @throws \CHttpException      partido no encontrado
     *
     * @return int                  flag de error (0 si no ha habido ningun error ; -1 cc)
     */
    public static function aumentar_factores_prop($id_partido, $id_equipo, $columna, $proporcion)
    {
        // buscar el partido
        $partido=Partidos::model()->findByPK($id_partido);
        if ($partido === null) {
            //Comprobación de seguridad
            throw new CHttpException(404,"Partido no encontrado. (aumentar_factores_prop,Helper.php)");
        }

        // equipo juega de local o visitante 
        if($partido->equipos_id_equipo_1 == $id_equipo) {
            $factor=self::$datos_factores['local'][$columna];

            //Aumentar proporcionalmente
            $valor_nuevo = $partido->$factor + ($partido->$factor * $proporcion);

            //Si fallara tiene que ser por el $factor,comprobar si es asi 
            $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
            
            if ($partido->save()) { 
                return 0;
            } else {
                return -1;
            }
        } else {
            if($partido->equipos_id_equipo_2 == $id_equipo) {
                $factor=self::$datos_factores['visitante'][$columna];

                //Aumentar proporcionalmente
                $valor_nuevo = $partido->$factor + ($partido->$factor * $proporcion);

                //Si fallara tiene que ser por el $factor,comprobar si es asi 
                $partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
                
                if ($partido->save()) { 
                    return 0;
                } else {
                    return -1;
                }
            } else {
                //Si ha llegado aqui por alguna cosa, es que no coincide con ninguno de 
                //los id de los equipo del partido
                return -1;
            }
        }
    }

}
