<?php

/**
 * Modelo de la tabla <<acciones_individuales>>
 *
 * Columnas disponibles
 * string $habilidades_id_habilidad
 * string $usuarios_id_usuario
 * string $cooldown
 */
class AccionesIndividuales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionesIndividuales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acciones_individuales';
	}

	/**
	 * @return array validation rules for model attributes.
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
	 * @devuelve array relaciones.
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
	 * @return array customized attribute labels (name=>label)
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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

	/*
	* Esta función finaliza las acciones grupales de un usuario concreto.
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
}