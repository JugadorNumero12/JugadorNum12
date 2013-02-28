<?php

/**
 * Modelo de la tabla <<usuarios>>
 *
 * Columnas disponibles
 * 	string 	$id_usuario
 * 	string 	$equipos_id_equipo
 * 	string 	$nick
 * 	string 	$pass
 * 	string 	$email
 * 	integer $personaje
 * 	string 	$nivel
 */
class Usuarios extends CActiveRecord
{
	const PERSONAJE_ULTRA = 0;
	const PERSONAJE_MOVEDORA = 1;
	const PERSONAJE_EMPRESARIO = 2;

	const BCRYPT_ROUNDS = 12;

	public $antigua_clave;
	public $nueva_clave1;
	public $nueva_clave2;
	public $antigua_email;
	public $nueva_email1;
	public $nueva_email2;
	public $nuevo_nick;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipos_id_equipo, nick, pass, email', 'required'),
			array('nueva_clave1,nueva_clave2,antigua_clave','safe','on'=>'cambiarClave'),
			array('personaje', 'numerical', 'integerOnly'=>true),
			array('equipos_id_equipo, nivel', 'length', 'max'=>10),
			array('nick', 'length', 'max'=>20),
			array('pass, email', 'length', 'max'=>255),
			/*Validaciones para cambio de contraseña*/
			array('nueva_clave1,nueva_clave2,antigua_clave','required','on'=>'cambiarClave','message'=>'Tienes que rellenar estos campos'),
			array('antigua_clave', 'clavesIguales','on'=>'cambiarClave'),
			array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'cambiarClave','message'=>'Deben coincidir las contrase&ntilde;as'),
			array('nueva_clave1,nueva_clave2', 'compare', 'operator'=>'!=','compareAttribute'=>'antigua_clave','on'=>'cambiarClave','message'=>'Debe ser distinta a la contrase&ntilde;a actual'),
			// Contraseña: minimo 6 caracteres, maximo 20. No hay restricciones de numeros o letras
			array('nueva_clave1,nueva_clave2','match','pattern'=>'/^[a-zA-Z0-9]{6,20}$/','message'=>'Contrase&ntilde;a inv&aacute;lida'),
			/*Validaciones para cambio de email*/
			array('nueva_email1,nueva_email2','comprobarEmail','on'=>'cambiarEmail'),
			array('nueva_email2', 'compare', 'compareAttribute'=>'nueva_email1','on'=>'cambiarEmail','message'=>'Deben coincidir los emails'),
			array('nueva_email1,nueva_email2,antigua_email','required','on'=>'cambiarEmail','message'=>'Tienes que rellenar estos campos'),
			array('antigua_email', 'emailIguales','on'=>'cambiarEmail'),
			/*Validaciones para registrar usuario*/
			array('nueva_email1','comprobarEmail','on'=>'registro'),
			array('nuevo_nick','comprobarNick','on'=>'registro'),
			array('nuevo_nick,nueva_email1,nueva_clave1,nueva_clave2','required','on'=>'registro','message'=>'Tienes que rellenar estos campos'),
			array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'registro','message'=>'Deben coincidir las contrase&ntilde;as'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_usuario, equipos_id_equipo, nick, pass, email, personaje, nivel', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Comprueba que la clave pasada por parámetro es válida con respecto a la clave de la base de datos.
	 *
	 * @param $clave Clave a comprobar
	 */
	public function comprobarClave ($clave)
	{
		$bcrypt = new Bcrypt(self::BCRYPT_ROUNDS);
		$valida = $bcrypt->verify($clave, $this->pass);

		return $valida;
	}

	/**
	 * Cambia la clave del usuario a la clave pasada por parámetro.
	 *
	 * @param $clave Nueva clase
	 */
	public function cambiarClave ($clave)
	{
		$bcrypt = new Bcrypt(self::BCRYPT_ROUNDS);
		$hash = $bcrypt->hash($clave);

		if ($hash === false) {
			return false;
		} else {
			$this['pass'] = $hash;
			return true;
		}
	}


	/*Compara para comprobar que su clave coincide con la de la BBDD*/
	public function clavesIguales($antigua_clave)
	{
	    $usuario = Usuarios:: model()->findByPk(Yii::app()->user->usIdent);
	    echo '$usuario->pass = ' . $usuario->pass
	       . '<br/>$antigua_clave = ' . $antigua_clave
	       . '<br/>$this->antigua_clave = ' . $this->antigua_clave;

	    if (!$usuario->comprobarClave($this->antigua_clave)) {
	        $this->addError($antigua_clave, 'Introduzca correctamente la contrase&ntilde;a actual');
	    }
	}

	/*Comprobar que el email coincide con el de la BBDD*/
	public function emailIguales($antigua_email)
	{
	    $usuario = Usuarios:: model()->findByPk(Yii::app()->user->usIdent);
	    if ( $usuario->email != $this->antigua_email)
	        $this->addError($antigua_email, 'Introduzca correctamente el email actual');
	}

	/*Comprueba que ese email sea único*/
	public function comprobarEmail($nueva_email1)
	{
	    $registro=Usuarios::model()->findByAttributes(array('email'=>$this->nueva_email1));

	    if($registro <> null){
	        $this->addError($nueva_email1, 'Ese email ya se encuentra registrado');
	    }
	}

	/*Comprobar que el nombre sea único*/
	public function comprobarNick($nuevo_nick)
	{
	    $registro=Usuarios::model()->findByAttributes(array('nick'=>$this->nuevo_nick));

	    if($registro <> null){
	        $this->addError($nuevo_nick, 'Ese nick ya se encuentra registrado');
	    }
	}

	/**
	 * Define las relaciones entre <usuarios - tabla>
	 *
	 * @devuelve array de relaciones
	 */
	public function relations()
	{
		/* ROBER */
		return array(
			/*Relacion entre <<usuarios>> y <<recursos>>*/
			'recursos'=>array(self::HAS_ONE, 'Recursos', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_individuales>>*/
            'accionesIndividuales'=>array(self::HAS_MANY, 'AccionesIndividuales', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<desbloqueadas>> */
			'desbloqueadas'=>array(self::HAS_MANY, 'Desbloqueadas', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<habilidades>>*/
			'habilidades'=>array(self::MANY_MANY,'Habilidades','Desbloquedas(usuarios_id_usuario,habilidades_id_habilidad)'), 
			/*Relacion entre <<usuarios>> y <<acciones_turno>> */
			'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<equipos>> */
			'equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo'),
			/*Relacion entre <<usuarios>> y <<participaciones>> */
			'participaciones'=>array(self::HAS_MANY, 'Participaciones', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_grupales>> */
			'accionesGrupales'=>array(self::HAS_MANY, 'AccionesGrupales', 'usuarios_id_usuario'),
			/*Relacion entre <<usuarios>> y <<acciones_turno>>*/
			'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'usuarios_id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Id Usuario',
			'equipos_id_equipo' => 'Equipos Id Equipo',
			'nick' => 'Nick',
			'pass' => 'Pass',
			'email' => 'Email',
			'personaje' => 'Personaje',
			'nivel' => 'Nivel',
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

		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('personaje',$this->personaje);
		$criteria->compare('nivel',$this->nivel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
