<?php

/**
 * Modelo de la tabla <<acciones_individuales>>
 *
 * Columnas disponibles
 *
 * | tipo   | nombre                    |
 * | :----- | :------------------------ |
 * | string | $habilidades_id_habilidad |
 * | string | $usuarios_id_usuario      |
 * | string | $cooldown                 |
 *
 * @package modelos
 */
class AccionesIndividuales extends CActiveRecord
{
	/**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
     * @return \AccionesIndividuales static model class
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
		return 'acciones_individuales';
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
			array('habilidades_id_habilidad, usuarios_id_usuario, cooldown', 'required'),
			array('habilidades_id_habilidad, usuarios_id_usuario', 'length', 'max'=>10),
			array('cooldown', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('habilidades_id_habilidad, usuarios_id_usuario, cooldown', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Define las relaciones entre <acciones_individuales - tabla>
	 *
	 * Relaciones definidas:
     *
     * - habilidades
     * - usuarios
     *
	 * > Funcion predeterminada de Yii
	 *
	 * @return object[]     relaciones entre clasificacion - tabla
     */
	public function relations()
	{
		/* PEDRO */
		return array(
			//Relación entre "acciones_individuales" y "habilidades"
			'habilidades' => array(self::BELONGS_TO, 'Habilidades', 'habilidades_id_habilidad'),
			//Relación entre "acciones_individuales" y "usuarios"
			'usuarios' => array(self::BELONGS_TO, 'Usuarios', 'usuarios_id_usuario')
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
			'cooldown' => 'Cooldown',
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

		$criteria->compare('habilidades_id_habilidad',$this->habilidades_id_habilidad,true);
		$criteria->compare('usuarios_id_usuario',$this->usuarios_id_usuario,true);
		$criteria->compare('cooldown',$this->cooldown,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Esta función finaliza las acciones grupales de un usuario concreto.
	 * 
	 * @param int $id_usuario   id del usuario
	 * @throws \CHttpException 404 Error: habilidad no encontrada.
	 * @throws \CHttpException 404 Error: no se ha podido guardar el modelo de acciones individuales.
	 * @return void
	 */
	public function finalizaIndividuales($id_usuario)
	{
		$transaction = Yii::app()->db->beginTransaction();
    	try
    	{
			Yii::import('application.components.Acciones.*');

			$tiempo = time();
			$busqueda=new CDbCriteria;
			$busqueda->addCondition(':bTiempo >= cooldown');
			$busqueda->addCondition('devuelto = :bDevuelto');
			$busqueda->addCondition('usuarios_id_usuario = :bUsuario');
			$busqueda->params = array(':bTiempo' => $tiempo,
									':bUsuario' => $id_usuario,
									':bDevuelto' => 0,
									);
			$individuales = AccionesIndividuales::model()->findAll($busqueda);

			//Iterar sobre cada individual y finalizarla
			foreach ($individuales as $ind)
			{
        		//Tomar nombre de habilidad para instanciación dinámica
        		$hab = Habilidades::model()->findByPk($ind->habilidades_id_habilidad);
        		if ($hab === null)
        		{
        			throw new CHttpException(404,"Error: habilidad no encontrada. (actionFinalizaIndividuales,ScriptsController)");
        			
        		}        		
        		$nombreHabilidad =  $hab->codigo;

        		//Llamar al singleton correspondiente y finalizar dicha acción
        		$nombreHabilidad::getInstance()->finalizar($ind->usuarios_id_usuario,$ind->habilidades_id_habilidad);

        		//Actualizar la base de datos para permitir un nuevo uso de la acción
        		$ind->devuelto = 1;

        		if (!$ind->save())
        		{
        			throw new CHttpException(404,"Error: no se ha podido guardar el modelo de acciones individuales. (actionFinalizaIndividuales,ScriptsController)");
        			
        		}
			}

			//Finalizar correctamente la transacción  
			$transaction->commit();     		
    	}
    	catch (Exception $ex)
    	{
    		//Rollback de la transacción en caso de error
    		$transaction->rollback();
    		//throw $ex; -> Deshabilitado para no dar fallos continuamente. Justificado.
    	}
	}

	/**
	 * Función empleada para usar una habilidad individual
	 * 
	 * @param int $id_usuario   id del usuario
	 * @param int $id_accion
	 * @param $res
	 * @param $habilidad
	 * @throws \Exception   'La habilidad no se ha regenerado todavía.'
	 * @return void
	 */	
	public static function usarIndividual($id_usuario, $id_accion, $res, $habilidad)
	{
		// Importar acciones
		Yii::import('application.components.Acciones.*');

		// Crear criteria de búsqueda
		$criteria = new CDbCriteria();
		$criteria->addCondition('usuarios_id_usuario=:bid_usuario');
		$criteria->addCondition('habilidades_id_habilidad=:bid_accion');
		$criteria->params = array(	':bid_usuario' => $id_usuario,
									':bid_accion' => $id_accion,
									);	
		$accion_ind = AccionesIndividuales::model()->find($criteria);
		$tiempo_reg = $habilidad['cooldown_fin'];

		if($accion_ind===null)
		{
			$accion_ind = new AccionesIndividuales();
			$accion_ind->setAttributes(	array('usuarios_id_usuario' => $id_usuario,
			   							  	  'habilidades_id_habilidad' => $id_accion,
			   							  	  'cooldown' => 0 ,
			   							  	  'devuelto'=> 0));

			$res['dinero'] 		-= $habilidad['dinero'];
			$res['animo']  		-= $habilidad['animo'];
			$res['influencias'] -= $habilidad['influencias'];
			$res->save();

			//actualizar la hora en que acaba de regenerarse la accion
			$accion_ind->cooldown = time() + $tiempo_reg;
			$accion_ind->devuelto=0;
			
			//guardar en los modelo				
			$accion_ind->save();

			//Tomar nombre de habilidad para instanciación dinámica	
    		$nombreHabilidad = $habilidad->codigo;

    		//Llamar al singleton correspondiente y ejecutar dicha acción
    		$nombreHabilidad::getInstance()->ejecutar($id_usuario);	

		}
		elseif($accion_ind->devuelto == 1)
		{		
			$res['dinero'] 		-= $habilidad['dinero'];
			$res['animo']  		-= $habilidad['animo'];
			$res['influencias'] -= $habilidad['influencias'];
			$res->save();

			//actualizar la hora en que acaba de regenerarse la accion
			$accion_ind->cooldown = time() + $tiempo_reg;
			$accion_ind->devuelto=0;
			
			//guardar en los modelo				
			$accion_ind->save();

			//Tomar nombre de habilidad para instanciación dinámica	
    		$nombreHabilidad = $habilidad->codigo;

    		//Llamar al singleton correspondiente y ejecutar dicha acción
    		$nombreHabilidad::getInstance()->ejecutar($id_usuario);
		}
		else
		{
			Yii::app()->user->setFlash('regen', 'La habilidad no se ha regenerado todavía.');
			//$this-> redirect(array('acciones/index'));
			throw new Exception('La habilidad no se ha regenerado todavía.');			
		}
	}
}