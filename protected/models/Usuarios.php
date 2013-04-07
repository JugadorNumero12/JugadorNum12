<?php

/**
 * Modelo de la tabla <<usuarios>>
 *
 * Columnas disponibles
 * ---------------------
 * 	int 	$id_usuario
 * 	int 	$equipos_id_equipo
 * 	string 	$nick
 * 	string 	$pass
 * 	string 	$email
 * 	tinyint $personaje
 * 	tinyint	$nivel
 * 	int 	$exp
 * 	int 	$exp_necesaria
 */
class Usuarios extends CActiveRecord
{
	const PERSONAJE_ULTRA = 0;
	const PERSONAJE_MOVEDORA = 1;
	const PERSONAJE_EMPRESARIO = 2;

    /*
        const DINERO_BASE = 6000;
        const DINERO_GEN_BASE = 10.0;
        const INFLUENCIAS_BASE = 
        const INFLUENCIAS_MAX_BASE = 
        const INFLUENCIAS_GEN_BASE = 0.1;
        const ANIMO_BASE = 30;
        const ANIMO_MAX_BASE = 
        const ANIMO_GEN_BASE = 1.0;
    */

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
     * Deben definirse solo reglas para aquellos atributos que recibiran entradas
     * del usuario
     *
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('nick, pass, email', 'required'),
			array('nueva_clave1,nueva_clave2,antigua_clave','safe','on'=>'cambiarClave'),
			array('personaje', 'numerical', 'integerOnly'=>true),
			array('equipos_id_equipo', 'length', 'max'=>10),
			array('nick', 'length', 'max'=>20),
			array('pass, email', 'length', 'max'=>255),
			array('nivel exp exp_necesaria', 'numerical', 'integerOnly'=>true),
            array('nivel', 'length', 'max'=>10),

            /* Validaciones para cambio de contraseña */
			array('nueva_clave1,nueva_clave2,antigua_clave','required','on'=>'cambiarClave','message'=>'Tienes que rellenar estos campos'),
			array('antigua_clave', 'clavesIguales','on'=>'cambiarClave'),
			array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'cambiarClave','message'=>'Deben coincidir las contrase&ntilde;as'),
			array('nueva_clave1,nueva_clave2', 'compare', 'operator'=>'!=','compareAttribute'=>'antigua_clave','on'=>'cambiarClave','message'=>'Debe ser distinta a la contrase&ntilde;a actual'),
			
            /* Validacion de la contraseña */
			array('nueva_clave1,nueva_clave2','match','pattern'=>'/^.{6,}$/','message'=>'Contrase&ntilde;a inv&aacute;lida'),
			
            /* Validaciones para el cambio de email*/
			array('nueva_email1,nueva_email2','comprobarEmail','on'=>'cambiarEmail'),
			array('nueva_email2', 'compare', 'compareAttribute'=>'nueva_email1','on'=>'cambiarEmail','message'=>'Deben coincidir los emails'),
			array('nueva_email1,nueva_email2,antigua_email','required','on'=>'cambiarEmail','message'=>'Tienes que rellenar estos campos'),
			array('antigua_email', 'emailIguales','on'=>'cambiarEmail'),
			
            /*Validaciones para registrar usuario*/
			array('nueva_email1','comprobarEmail','on'=>'registro'),
			array('nuevo_nick','comprobarNick','on'=>'registro'),
			array('nuevo_nick',  'required','on'=>'registro','message'=>'Introduzca un nick válido.'),
			array('nueva_email1','required','on'=>'registro','message'=>'Introduzca un e-mail válido.'),
			array('nueva_clave1','required','on'=>'registro','message'=>'Introduzca una contraseña.'),
			array('nueva_clave2','required','on'=>'registro','message'=>'Repita la contraseña.'),
			array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'registro','message'=>'Deben coincidir las contrase&ntilde;as'),
			
			// Regla usada por la funcion search() ; No se incluyen aquellos atributos que no se usen para buscar
            // Atributos no incluidos
            //  - pass
            //  - exp_necesaria
			array('id_usuario, equipos_id_equipo, nick, email, personaje, nivel, exp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Comprueba que la clave pasada por parámetro es válida con respecto a la clave de la base de datos.
	 *
	 * @param $clave Clave a comprobar
     * @return Clave válida
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
     * @return éxito
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


	/**
     * Compara para comprobar que su clave coincide con la de la BBDD
     * 
     * @param $antigua_clave
     */
	public function clavesIguales($antigua_clave)
	{
	    $usuario = Usuarios:: model()->findByPk(Yii::app()->user->usIdent);

	    if (!$usuario->comprobarClave($this->antigua_clave)) {
	        $this->addError($antigua_clave, 'Introduzca correctamente la contrase&ntilde;a actual');
	    }
	}

	/**
     * Comprobar que el email coincide con el de la BBDD
     *
     * @param $antigua_email
     */
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
	 * Define las relaciones entre <usuarios> - <tabla>
	 *
	 * @return array de relaciones
	 */
	public function relations()
	{
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
            'exp' => 'Experiencia',
            'exp_necesaria' => 'Experiencia Necesaria'
		);
	}

	/**
     * Warning: Please modify the following code to remove attributes that
     * should not be searched.
     *
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;

        /* Atributos no contemplados para la búsqueda
            - pass
            - exp_necesaria
        */
		
        $criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('personaje',$this->personaje);
		$criteria->compare('nivel',$this->nivel,true);
        $criteria->compare('exp',$this->exp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
	 * Función que se encarga de :
     *  - generar recursos
     *  - finalizar acciones individuales
     *  - finalizar acciones grupales
	 */
	public function actualizaDatos($id_usuario)
	{
		//Actualizar todos los datos necesarios
		AccionesIndividuales::model()->finalizaIndividuales($id_usuario);
		AccionesGrupales::model()->finalizaGrupales();
		Recursos::model()->actualizaRecursos($id_usuario);
        // TODO EXP: comprobar el siguiente nivel.
	}

    /**
     * Devuelve la experencia necesaria para alcanzar el siguiente nivel
     * La experencia necesaria depende del nivel actual y un modificador 
     * la curvatura de dificultad es de 1.1^nivel
     *
     * @param $nivel_actual 
     * @param $modificador ; valor por defecto 500.
     * @return experencia necesaria para alcanzar el siguiente nivel.
     */
    public static function exp_necesaria($nivel_actual, $modificador = 500)
    {
        return   $modificador * pow( 1.1, ($nivel_actual) );
    }

    /**
     * Fija los atributos del nuevo personaje:
     *  - Recursos iniciales en funcion del personaje escogido
     *  - nivel y experencia iniciales
     */
    public function crearPersonaje()
    {
        /* NIVEL Y EXP */
        $this->setAttributes(array('nivel'=>1));
        $this->setAttributes(array('exp'=>0));
        $exp_necesaria_lv_2 = Usuarios::exp_necesaria(1);
        $this->setAttributes(array( 'exp_necesaria'=> $exp_necesaria_lv_2));
        
        /* RECURSOS */
        $rec=new Recursos;
        $rec->setAttributes(array('usuarios_id_usuario'=>$this->id_usuario));
        
        switch ($this->personaje) {

            case Usuarios::PERSONAJE_MOVEDORA: 
                $rec->setAttributes(array('dinero'=>2400));
                $rec->setAttributes(array('dinero_gen'=>20.0));
                $rec->setAttributes(array('influencias'=>5));
                $rec->setAttributes(array('influencias_max'=>12));
                $rec->setAttributes(array('influencias_gen'=>3.0));
                $rec->setAttributes(array('animo'=>50));
                $rec->setAttributes(array('animo_max'=>250));
                $rec->setAttributes(array('animo_gen'=>9.0));
                break;

            case Usuarios::PERSONAJE_EMPRESARIO: 
                $rec->setAttributes(array('dinero'=>20000));
                $rec->setAttributes(array('dinero_gen'=>160.0));
                $rec->setAttributes(array('influencias'=>3));
                $rec->setAttributes(array('influencias_max'=>8));
                $rec->setAttributes(array('influencias_gen'=>2.0));
                $rec->setAttributes(array('animo'=>15));
                $rec->setAttributes(array('animo_max'=>50));
                $rec->setAttributes(array('animo_gen'=>1.0));
                break;

            case Usuarios::PERSONAJE_ULTRA:
                $rec->setAttributes(array('dinero'=>8000));
                $rec->setAttributes(array('dinero_gen'=>50.0));
                $rec->setAttributes(array('influencias'=>1));
                $rec->setAttributes(array('influencias_max'=>2));
                $rec->setAttributes(array('influencias_gen'=>1.0));
                $rec->setAttributes(array('animo'=>100));
                $rec->setAttributes(array('animo_max'=>400));
                $rec->setAttributes(array('animo_gen'=>15.0));
                break;
            
            default: 
                break;
        }
        $rec->setAttributes(array('ultima_act'=> time()));
        $rec->save();

        $this->save();
    }

}
