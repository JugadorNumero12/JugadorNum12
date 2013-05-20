<?php

/**
 * Modelo de la tabla <<emails>>
 *
 * Columnas disponibles:
 *
 * | tipo   | nombre             |
 * | :----- | :----------------- |
 * | string |	$id_email        |
 * | string |	$id_usuario_to   |
 * | string |	$id_usuario_from |
 * | string |	$fecha           |
 * | string |	$contenido       |
 * | string	|   $leido           |
 * | string |	$asunto          |
 * | string |	$borrado_to      |
 * | string |	$borrado_from    |
 *
 *
 * @package modelos
 */
class Emails extends CActiveRecord
{
	public $nombre;

	/**
     * Devuelve el modelo estatico de la clase active record especificada.
     *
     * > Funcion predetirmada de Yii
     *
     * @static
     * @param string $className     nombre de la clase active record
     * @return \Emails    el modelo estatico de la clase
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
		return 'emails';
	}

	/**
     * Define las reglas definidas para los atributos del modelo.
     *
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
			array('asunto', 'length', 'max'=>50),
			array('id_email, id_usuario_to, id_usuario_from', 'length', 'max'=>10),
			array('leido,borrado_to,borrado_from', 'length', 'max'=>1),
			array('fecha', 'length', 'max'=>11),

			/*Validaciones para redactar email*/
			array('nombre,contenido,asunto', 'safe', 'on'=>'redactar'),
			array('nombre','comprobarNombres','on'=>'redactar'),
			array('nombre,contenido,asunto','required','on'=>'redactar','message'=>'Tienes que rellenar este campo'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_email, id_usuario_to, id_usuario_from, fecha, contenido, leido, asunto,borrado_to,borrado_from', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Saca los usuarios de destino de un mensaje.
	 *
	 * espera algo como user1,user2,user3 y lo se para por las comas
	 *
	 * @param string $usuarios usuarios destinatarios del mensaje
	 *
	 * @return object[] array de usuarios
	 */
	public function sacarUsuarios($usuarios){

		$usur_descomp = explode(",", $usuarios);
		return $usur_descomp;

	}

	/**
     * Comprueba que los nombres existen
     * 
     * @param $attribute
     * @param $params
     * @return void
     */
	public function comprobarNombres($attribute, $params)
	{
		$str = '';
		$cont = 0;
		$nombs = $this->sacarUsuarios($this->nombre);
		foreach($nombs as $nomb){
			$nomb = trim($nomb);
			$n = Usuarios::model()->findByAttributes(array('nick'=>$nomb));
			if($n === null){
				if($cont==0){
					$str = $nomb;
					$cont += 1;
				}elseif($cont==1){
					$str = 'Los usuarios -'.$str.','.$nomb;
					$cont += 1;
				}else{
					$str .= '.'.$nomb;
					$cont += 1;
				}
			}
		}
		if($cont == 1){
			$this->addError('nombre', 'El usuario -'.$str.'- no existe.');
		}elseif($cont>1){
			$this->addError('nombre', $str.'- no existen.');
		}
	}

	/**
     * Compara todos los nombres con su nick
     * 
     * @return object[] array con los nombres
     */
	public function nombres()
	{
		//var_dump($nombre);
		$nombres = array();
		$cont = 0;
		$usuarios = Usuarios::model()->findAll();
		foreach($usuarios as $usr){
			$nombe[$cont] = $usr->nick;
			$cont++;
		}
		return $nombres;
	}

	/**
	 * Define las relaciones entre <emails - tabla>
	 *
     * Relaciones definidas:
     *
     * - usuarios
     *
     * > Funcion predeterminada de Yii
     *
	 * @return object[] array de relaciones
	 */
	public function relations()
	{
		return array(
			/*Relacion entre <<emails>> y <<usuarios>>*/
			'usuarioTo'=>array(self::BELONGS_TO, 'Usuarios', 'id_usuario_to'),
			/*Relacion entre <<emails>> y <<usuarios>>*/
			'usuarioFor'=>array(self::BELONGS_TO, 'Usuarios', 'id_usuario_from'),
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
			'id_email' => 'Id Email',
			'id_usuario_to' => 'Id Usuario Para',
			'id_usuario_from' => 'Id Usuario De',
			'fecha' => 'Fecha',
			'contenido' => 'Contenido',
			'leido' => 'Leido',
			'asunto' => 'Asunto',
			'borrado_to' => 'Borrado To',
			'borrado_from' => 'Borrado From'
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

		$criteria->compare('id_email',$this->id_email,true);
		$criteria->compare('id_usuario_to',$this->id_usuario_to,true);
		$criteria->compare('id_usuario_from',$this->id_usuario_from,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('leido',$this->leido);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('borrado_to',$this->borrado_to,true);
		$criteria->compare('borrado_from',$this->borrado_from,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}