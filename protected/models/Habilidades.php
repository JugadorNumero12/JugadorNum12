<?php

/**
 * Modelo de la tabla habilidades
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre             |
 * |:-------|:-------------------|
 * | string | $id_habilidad      |
 * | string | $codigo            |
 *
 *
 * @package modelos
 */
class Habilidades extends CActiveRecord
{
    /** Definicion de las habilidades grupales : 0 */ 
    const TIPO_GRUPAL = 0;
    /** Definicion de las habilidades individuales : 1 */
    const TIPO_INDIVIDUAL = 1;
    /** Definicion de las habilidades de partido : 2 */
    const TIPO_PARTIDO = 2;
    /** Definicion de las acciones pasivas : 3 */
    const TIPO_PASIVA = 3;

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
        return 'habilidades';
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
            array('codigo, tipo, nombre, descripcion, dinero, animo, influencias, participantes_max', 'required'),
            array('codigo, dinero, animo, influencias, participantes_max, dinero_max, animo_max, influencias_max, cooldown_fin', 'length', 'max'=>10),
            array('dinero', 'length', 'max'=>11),
            array('id_habilidad, codigo', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * Comprueba que el usuario puede desbloquear la habilidad.
     *
     * Las restricciones actuales son:
     *
     * - Nivel del jugador
     * - Lista de habilidades requeridas 
	 *
	 * @param int $id_usuario      usuario que quiere desbloquear la habilidad
	 * @param int $id_habilidad    habilidad que quiere ser desbloqueada
     * @return boolean             flag si la habilidad puede ser desbloqueada (true si es capaz, false cc)
	 */
	public function puedeDesbloquear($id_usuario, $id_habilidad)
	{
		//Obtenemos los datos del usuario (para consultar el nivel)
		$usuario = Usuarios::model()->findByPk($id_usuario);

		//Obtenemos los datos de la habilidad (para consultar su codigo)
		$habilidad = Habilidades::model()->findByPk($id_habilidad);

		$puedeDesbloquear=true;
		$comentarioFlash = "";

		//1) comprobamos que el usario tenga un nivel igual o superior al requisito para desbloquear la habilidad y que tenga puntos de desbloqueo
		if (($usuario->nivel < RequisitosDesbloquearHabilidades::$datos_acciones[$habilidad->codigo]['nivel']) || ($usuario->puntos_desbloqueo == 0)){
			$comentarioFlash .= "Nivel insuficiente. ";
			$puedeDesbloquear = false;
		}

		//2) Comprobamos que el usuario haya desbloqueado las habilidades requisito antes de intentar desbloquear esta

		//sacamos las habilidades requisito
		$habilidadesRequisito = RequisitosDesbloquearHabilidades::$datos_acciones[$habilidad->codigo]['desbloqueadas_previas'];

		if($habilidadesRequisito !== null){

			//Comprobamos que las haya desbloqueado
			foreach ($habilidadesRequisito as $habilidadReq) {
				//Con el codigo de la habilidad saco la habilidad requisito
				$habilidadAux = Habilidades::model()->findByAttributes((array('codigo'=> $habilidadReq)));
				//miro si el usuario tiene esa habilidad desbloqueada
				$desbloqueada = Desbloqueadas::model()->findByAttributes((array('habilidades_id_habilidad'=> $habilidadAux->id_habilidad, 'usuarios_id_usuario'=> $id_usuario)));

				if($desbloqueada === null){
					$puedeDesbloquear = false; 
					$comentarioFlash .= "Desbloquea antes ".$habilidadReq.". ";
				}
				
			}
		}

		if($puedeDesbloquear == false){
			//Yii::app()->user->setFlash('desbloqueada', $comentarioFlash);
		}

		return $puedeDesbloquear;
	}

    /**
     * Define las relaciones entre la tabla habilidades y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - desbloqueadas
     * - accionesIndividuales
     * - accionesGrupales
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre habilidades - tabla
     */
    public function relations()
    {
        return array(
            'desbloqueadas' => array(self::HAS_MANY, 'Desbloqueadas', 'habilidades_id_habilidad'),
            'accionesIndividuales' => array(self::HAS_MANY, 'AccionesIndividuales', 'habilidades_id_habilidad'),
            'accionesGrupales' => array(self::HAS_MANY, 'AccionesGrupales', 'habilidades_id_habilidad'),
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
            'id_habilidad' => 'ID',
            'codigo' => 'Codigo',
            'tipo' => 'Tipo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripci&oacute;n',
            'dinero' => 'Dinero',
            'animo' => '&Aacute;nimo',
            'influencias' => 'Influencia',
            'dinero_max' => 'Dinero MAX',
            'animo_max' => '&Aacute;nimo MAX',
            'influencias_max' => 'Influencia MAX',
            'participantes_max' => 'Participantes m&aacute;ximos',
            'cooldown_fin' => 'Cooldown/Fin'
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

        $criteria->compare('id_habilidad',$this->id_habilidad,true);
        $criteria->compare('codigo',$this->codigo,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria,));
    }

}
