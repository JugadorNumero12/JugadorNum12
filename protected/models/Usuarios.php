<?php

/**
 * Modelo de la tabla usuarios
 *
 * Columnas disponibles:
 *
 * |tipo    | nombre                        |
 * |:-------|:------------------------------|
 * | int    | $id_usuario                   |
 * | int    | $equipos_id_equipo            |
 * | string | $nick                         |
 * | string | $pass                         |
 * | string | $email                        |
 * | tinyint| $personaje                    |
 * | tinyint| $nivel                        |
 * | int    | $exp                          |
 * | int    | $exp_necesaria                |
 * | int    | $puntos_desbloqueo            |
 *
 *
 * @package modelos
 */
class Usuarios extends CActiveRecord
{
    /** Seguridad de contraseñas : determina el numero de vueltas del algoritmo */
    const BCRYPT_ROUNDS = 12;
    
    /** Identificador del personaje ultra : 0 */
    const PERSONAJE_ULTRA = 0;
    /** Identificador del personaje RRPP : 1 */
    const PERSONAJE_MOVEDORA = 1;
    /** Identificador del personaje empresario : 2 */
    const PERSONAJE_EMPRESARIO = 2;

    /** Modulo de experencia: poca experencia */
    const POCA_EXP = 50;
    /** Modulo de experencia: media experencia */
    const MEDIA_EXP = 100;
    /** Modulo de experencia: bastante experencia */
    const BASTANTE_EXP = 400;
    /** Modulo de experencia: mucha experenia */
    const MUCHA_EXP = 1000;

    /** Modulo de experencia: probabilidad de mejorar el recurso mayoritario */ 
    const PROPORCION_MAYOR = 55;
    /** Modulo de experencia: probabilidad de mejorar el recurso mediano */
    const PROPORCION_INTERMEDIA = 30;
    /** Modulo de experencia: probabilidad de mejorar el recurso minoritario */
    const PROPORCION_MENOR = 15;
    
    /** Modulo de experencia: unidad de aumento para el atributo generacion de dinero */
    const UNIDAD_DINERO_GEN = 110;
    /** Modulo de experencia: unidad de aumento para el atributo generacion de animo */
    const UNIDAD_ANIMO_GEN = 14;
    /** Modulo de experencia: unidad de aumento para el atributo generacion de influencias */
    const UNIDAD_INFLUENCIAS_GEN = 1;

    /** Modulo de experencia: define cada cuantos niveles se recalculara los atributos maximos */
    const FRECUENCIA_NIVELES= 5;
    /** Modulo de experencia: determina el numero de vueltas para el algoritmo al subir de nivel */
    const AUMENTOS_POR_NIVEL = 2;

    /** Modulo de experencia: unidad de aumento para el atributo influencias maximas de la RRPP */
    const ANIMADORA_UNIDAD_INFLUENCIAS_MAX = 70;
    /** Modulo de experencia: unidad de aumento para el atributo influencias maximas del empresario */
    const EMPRESARIO_UNIDAD_INFLUENCIAS_MAX = 44;
    /** Modulo de experencia: unidad de aumento para el atributo influencias maximas del ultra */
    const ULTRA_UNIDAD_INFLUENCIAS_MAX = 20;
    /** Modulo de experencia: unidad de aumento para el atributo animo maximo de la RRPP */
    const ANIMADORA_UNIDAD_ANIMO_MAX = 450; 
    /** Modulo de experencia: unidad de aumento para el atributo animo maximo del empresario */
    const EMPRESARIO_UNIDAD_ANIMO_MAX = 150;
    /** Modulo de experencia: unidad de aumento para el atributo animo maximo del ultra */
    const ULTRA_UNIDAD_ANIMO_MAX = 750;

    /** Modulo de experencia: modificador al calcular la experencia al participar en acciones con dinero */
    const MOD_EXP_DINERO = 0.1;
    /** Modulo de experencia: modificador al calcular la experencia al participar en acciones con animo */
    const MOD_EXP_ANIMO = 1;
    /** Modulo de experencia: modificador al calcular la experencia al participar en acciones con influencias */
    const MOD_EXP_INFLUENCIAS = 10;

    /** Recursos iniciales: dinero inicial para el ultra */
    const ULTRA_DINERO_INICIO = 9000;
    /** Recursos iniciales: dinero inicial para la RRPP */
    const ANIMADORA_DINERO_INICIO = 1000;
    /** Recursos iniciales: dinero inicial para el empresario */
    const EMPRESARIO_DINERO_INICIO = 25000;
    /** Recursos iniciales: animo inicial para el utra */
    const ULTRA_ANIMO_GEN_INICIO = 30;
    /** Recursos iniciales: animo inicial para la RRPP */
    const ANIMADORA_ANIMO_GEN_INICIO = 19;
    /** Recursos iniciales: animo inicial para el empresario */
    const EMPRESARIO_ANIMO_GEN_INICIO = 9;
    /** Recursos iniciales: generacion de dinero inicial para el ultra */
    const ULTRA_DINERO_GEN_INICIO = 24;
    /** Recursos iniciales: generacion de dinero inicial para la RRPP */
    const ANIMADORA_DINERO_GEN_INICIO = 7;
    /** Recursos iniciales: generacion de dinero inicial para el empresario */
    const EMPRESARIO_DINERO_GEN_INICIO = 40;
    /** Recursos iniciales: generacion de influencias inicial para el ultra */
    const ULTRA_INFLUENCIAS_GEN_INICIO = 3;
    /** Recursos iniciales: generacion de influencias inicial para la animadora */
    const ANIMADORA_INFLUENCIAS_GEN_INICIO = 10;
    /** Recursos iniciales: generacion de influencias inicial para el empresario */
    const EMPRESARIO_INFLUENCIAS_GEN_INICIO = 5;
    /** Recursos iniciales: animo maximo inicial para el ultra */
    const ULTRA_ANIMO_MAX_INICIO = 100;
    /** Recursos iniciales: animo maximo inicial para la RRPP */
    const ANIMADORA_ANIMO_MAX_INICIO = 60;
    /** Recursos iniciales: animo maximo inicial para el empresario */
    const EMPRESARIO_ANIMO_MAX_INICIO = 25;
    /** Recursos iniciales: influencias maximas para el ultra */
    const ULTRA_INFLUENCIAS_MAX_INICIO = 4; 
    /** Recursos iniciales: influencias maximas para la RRPP */
    const ANIMADORA_INFLUENCIAS_MAX_INICIO = 16;
    /** Recursos iniciales: influencias maximas para el empresario */
    const EMPRESARIO_INFLUENCIAS_MAX_INICIO = 9;

    /* ------------------------------------------------------------------------ */
    /* ------------------------------------------------------------------------ */

    /** @type string */
    public $antigua_clave;
    /** @type string */
    public $nueva_clave1;
    /** @type string */
    public $nueva_clave2;
    /** @type string */
    public $antigua_email;
    /** @type string */
    public $nueva_email1;
    /** @type string */
    public $nueva_email2;
    /** @type string */
    public $nuevo_nick;
    
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
        return 'usuarios'; 
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
            /* Reglas definidas */
            array('nick, pass, email', 'required'),
            array('nueva_clave1,nueva_clave2,antigua_clave','safe','on'=>'cambiarClave'),
            array('personaje', 'numerical', 'integerOnly'=>true),
            array('equipos_id_equipo', 'length', 'max'=>10),
            array('nick', 'length', 'max'=>20),
            array('pass, email', 'length', 'max'=>255),
            array('nivel exp exp_necesaria puntos_desbloqueo', 'numerical', 'integerOnly'=>true),
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
            
            /* Validaciones para registrar usuario*/
            array('nueva_email1','comprobarEmail','on'=>'registro'),
            array('nuevo_nick','comprobarNick','on'=>'registro'),
            array('nuevo_nick',  'required','on'=>'registro','message'=>'Introduzca un nick válido.'),
            array('nueva_email1','required','on'=>'registro','message'=>'Introduzca un e-mail válido.'),
            array('nueva_clave1','required','on'=>'registro','message'=>'Introduzca una contraseña.'),
            array('nueva_clave2','required','on'=>'registro','message'=>'Repita la contraseña.'),
            array('nueva_clave2', 'compare', 'compareAttribute'=>'nueva_clave1','on'=>'registro','message'=>'Deben coincidir las contrase&ntilde;as'),
            
            /* Regla usada por la funcion search() ; No se incluyen aquellos atributos que no se usen para buscar
             * Atributos no incluidos
             *  - pass
             *  - exp_necesaria
             *  - puntos_desbloqueo
             */
            array('id_usuario, equipos_id_equipo, nick, email, personaje, nivel, exp', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Comprueba que la clave pasada por parametro es valida con respecto a la clave de la base de datos
     *
     * @param string $clave     clave a comprobar
     * @return string           clave valida
     */
    public function comprobarClave ($clave)
    {
        $bcrypt = new Bcrypt(self::BCRYPT_ROUNDS);
        $valida = $bcrypt->verify($clave, $this->pass);
        return $valida;
    }

    /**
     * Cambia la clave del usuario a la clave pasada por parametro.
     *
     * @param string $clave     clave nueva 
     * @return boolean          flag de exito
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
     * Comprueba que la clave coincide con la de la BBDD
     * 
     * @param string $antigua_clave     
     * @return void
     */
    public function clavesIguales($attribute,$params)
    {
        $usuario = Usuarios:: model()->findByPk(Yii::app()->user->usIdent);
        if (!$usuario->comprobarClave($this->antigua_clave)) {
            $this->addError('antigua_clave', 'Introduzca correctamente la contrase&ntilde;a actual');
        }
    }

    /**
     * Comprueba que el email coincide con el de la BBDD
     *
     * @param string $antigua_email
     * @return void
     */
    public function emailIguales($attribute,$params)
    {
        // FIXME: no es necesario el parametro

        $usuario = Usuarios:: model()->findByPk(Yii::app()->user->usIdent);
        if ( $usuario->email != $this->antigua_email)
            $this->addError('antigua_email', 'Introduzca correctamente el email actual');
    }

    /**
     * Comprueba que el email pasado por parametro sea unico (no se encuentra ya registrado)
     * 
     * @param string $nuevo_email   email a comprobar
     * @return void
     */
    public function comprobarEmail($attribute,$params)
    {
        $registro=Usuarios::model()->findByAttributes(array('email'=>$this->nueva_email1));

        if($registro !== null){
            $this->addError('nueva_email1', 'Ese email ya se encuentra registrado');
        }
    }

    /**
     * Comprueba que el nombre pasado por parametro sea unico (no se encuentra ya registrado)
     *
     * @param string $nuevo_nick    nick a comprobar
     * @return void
     */
    public function comprobarNick($attribute,$params)
    {
        $registro=Usuarios::model()->findByAttributes(array('nick'=>$this->nuevo_nick));

        if($registro !== null){
            $this->addError('nuevo_nick', 'Ese nick ya se encuentra registrado');
        }
    }

    /**
     * Define las relaciones entre la tabla usuarios y el resto de tablas
     *
     * Relaciones definidas:
     *
     * - recursos
     * - accionesIndividuales
     * - desbloqueadas
     * - habilidades
     * - accionesTurno
     * - equipos
     * - participaciones
     * - accionesGrupales
     * - accionesTurno
     * - mensajesTo
     * - mensajesFrom
     * - usrnotificaciones
     *
     * > Funcion predeterminada de Yii
     *
     * @return object[]     relaciones entre usuario - tabla
     */
    public function relations()
    {
        return array(
            'recursos'=>array(self::HAS_ONE, 'Recursos', 'usuarios_id_usuario'),
            'accionesIndividuales'=>array(self::HAS_MANY, 'AccionesIndividuales', 'usuarios_id_usuario'),
            'desbloqueadas'=>array(self::HAS_MANY, 'Desbloqueadas', 'usuarios_id_usuario'),
            'habilidades'=>array(self::MANY_MANY,'Habilidades','Desbloquedas(usuarios_id_usuario,habilidades_id_habilidad)'), 
            'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'usuarios_id_usuario'),
            'equipos'=>array(self::BELONGS_TO, 'Equipos', 'equipos_id_equipo'),
            'participaciones'=>array(self::HAS_MANY, 'Participaciones', 'usuarios_id_usuario'),
            'accionesGrupales'=>array(self::HAS_MANY, 'AccionesGrupales', 'usuarios_id_usuario'),
            'accionesTurno'=>array(self::HAS_MANY, 'AccionesTurno', 'usuarios_id_usuario'),
            'mensajesTo'=>array(self::HAS_MANY, 'Emails',  'id_usuario_to'),
            'mensajesFrom'=>array(self::HAS_MANY, 'Emails', 'id_usuario_from'),
            'usrnotificaciones'=>array(self::HAS_MANY, 'Usrnotif', 'usuarios_id_usuario'),
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
            'id_usuario' => 'Id Usuario',
            'equipos_id_equipo' => 'Equipos Id Equipo',
            'nick' => 'Nick',
            'pass' => 'Pass',
            'email' => 'Email',
            'personaje' => 'Personaje',
            'nivel' => 'Nivel',
            'exp' => 'Experiencia',
            'exp_necesaria' => 'Experiencia Necesaria',
            'puntos_desbloqueo' => 'Puntos Desbloqueo'
        );
    }

    /**
     * Devuelve la lista de modelos con las condiciones de busqueda/filtro
     *
     * Atributos no contemplados para la busqueda
     *
     * - pass
     * - exp_necesaria
     *
     * > Funcion predeterminada de Yii
     *
     * @return \CActiveDataProvider[]   criterio definidos para las busquedas
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id_usuario',$this->id_usuario,true);
        $criteria->compare('equipos_id_equipo',$this->equipos_id_equipo,true);
        $criteria->compare('nick',$this->nick,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('personaje',$this->personaje);
        $criteria->compare('nivel',$this->nivel,true);
        $criteria->compare('exp',$this->exp,true);
        $criteria->compare('puntos_desbloqueo',$this->puntos_desbloqueo,true);

        return new CActiveDataProvider($this, array('criteria'=>$criteria));
    }

    /**
     * Funcion que se encarga de actualizar recursos y acciones del usuario
     *
     * Datos que se actualizan:
     *
     *  - generar recursos
     *  - finalizar acciones individuales
     *  - finalizar acciones grupales
     *
     * @param int $id_usuario   id del usuario que se va a actualizar
     * @return void
     */
    public function actualizaDatos($id_usuario)
    {
        AccionesIndividuales::model()->finalizaIndividuales($id_usuario);
        AccionesGrupales::model()->finalizaGrupales();
        Recursos::model()->actualizaRecursos($id_usuario);
    }

    /**
     * Devuelve la experencia necesaria para alcanzar el siguiente nivel.
     *
     * La experencia necesaria depende del nivel actual y un modificador 
     *
     * La curva se ha encontrado en
     * <stackoverflow.com/questions/6954874/php-game-formula-to-calculate-a-level-based-on-exp>
     *
     * @static
     *
     * @param int $nivel_actual     nivel del jugador
     * @param int $modificador      modificador para determinar la curva; dejar en su valor por defecto
     * 
     * @return int                  experencia necesaria para alcanzar el siguiente nivel
     */
    public static function expNecesaria($nivel_actual, $modificador = 30)
    {
        $a = pow(($nivel_actual+1),3);
        $b = $modificador*pow(($nivel_actual+1),2);
        $c = $modificador*($nivel_actual+1);
        return (int) ($a+$b+$c);
    }

    /** 
     * Suma la experiencia indicada al jugador
     *
     * Si el jugador sube de nivel, actualiza los valores de:
     *
     *  - indicadores de recursos
     *  - nivel
     *  - exp_necesaria
     *  - puntos_desbloqueo
     * 
     * > La funcion contempla la posibilidad de subir varios niveles de golpe
     * 
     * @param int $exp  experencia a sumar al jugador
     * @return boolean  indicador si el jugador ha subido de nivel (true si el jugador ha subido)
     */
    public function sumarExp($exp)
    {
        /* Experencia acumulada */
        $exp_acc = $this->exp + $exp;
        $this->setAttributes(array('exp'=>$exp_acc));

        /* Comprobar si subimos de nivel */
        if ($exp_acc >= $this->exp_necesaria) {

            $nivel_actual = $this->nivel;
            $nivel_inicial = $nivel_actual; 
            $exp_sig_nivel = $this->exp_necesaria;
            $puntos_desbloqueo = $this->puntos_desbloqueo;
            
            /* Posible subir varios niveles */
            while($exp_acc >= $exp_sig_nivel) {
                $nivel_actual = $nivel_actual + 1;
                $puntos_desbloqueo += 1;
                Yii::app()->user->setFlash('nivel', 'Enhorabuena, has subido de nivel. Ahora tienes nivel '. $nivel_actual);
                $exp_sig_nivel = Usuarios::expNecesaria($nivel_actual);

                //Creamos una notificacion para el nivel y otra para los puntos de desbloqueo
                $notificacionNivel = new Notificaciones;
                $notificacionNivel->fecha = time();
                $notificacionNivel->mensaje = " Enhorabuena, has subido de nivel. Ahora tienes nivel ". $nivel_actual;
                $notificacionNivel->imagen = "images/iconos/notificaciones/nivel.png";
                $notificacionNivel->save();

                $notificacionPuntos = new Notificaciones;
                $notificacionPuntos->fecha = time();
                $notificacionPuntos->mensaje = " Tus puntos de desbloqueo han aumentado. Ahora tienes ". $puntos_desbloqueo;
                $notificacionPuntos->imagen = "images/iconos/notificaciones/puntos_desbloqueo.png";
                $notificacionPuntos->save();

                //Guardamos las notificaciones en ursnotif
                $usrnotif = new Usrnotif;
                $usrnotif->notificaciones_id_notificacion = $notificacionNivel->id_notificacion;
                $usrnotif->usuarios_id_usuario = $this->id_usuario;
                $usrnotif->save();

                $usrnotifPuntos = new Usrnotif;
                $usrnotifPuntos->notificaciones_id_notificacion = $notificacionPuntos->id_notificacion;
                $usrnotifPuntos->usuarios_id_usuario = $this->id_usuario;
                $usrnotifPuntos->save();
                
            }

            /* Obtener los nuevos valores de los atributos del personaje:
             * ritmo de generacion de recursos 
             * valores maximos de los recursos */
            $nuevos_atributos = $this->actualizarAtributos($nivel_inicial, $nivel_actual);

            /* Guardamos los nuevos atributos del usuario */
            $this->setAttributes( array( 
                'nivel'=>$nivel_actual,
                'exp_necesaria'=>$exp_sig_nivel,
                'puntos_desbloqueo'=>$puntos_desbloqueo
            ));;
            $this->recursos->setAttributes( array(
                'dinero_gen'=>      $nuevos_atributos['dinero_gen'],
                'animo_gen'=>       $nuevos_atributos['animo_gen'],
                'influencias_gen'=> $nuevos_atributos['influencias_gen'],
                'animo_max'=>       $nuevos_atributos['animo_max'],
                'influencias_max'=> $nuevos_atributos['influencias_max'],
                'influencias_bloqueadas'=>$nuevos_atributos['influencias_bloqueadas']
            ));
            $this->save();
            $this->recursos->save();

            return true;
        } else {
            /* No aumentamos de nivel: guardamos la nueva exp acumulada */
            $this->save();
            return false;
        }
    } 

    /**
     * Actualiza los atributos del jugador al subir de nivel
     *
     * Calcula los nuevos valores de generacion de recursos y valor maximo:
     *
     *  - dinero_gen
     *  - animo_gen
     *  - influencias_gen
     *  - animo_max
     *  - influencias_max
     * 
     * > dinero_gen, animo_gen e influencias_gen son los <r_gen>
     *
     * > animo_max e influencias_max son los <r_max>
     *
     * Para determinar los nuevos valores, nos basaremos en el personaje y las siguientes reglas:
     * 
     * 1) Se aumentan AUMENTOS_POR_NIVEL "r_gen" por nivel
     *
     * 2) La probabilidad de aumentar un determinado "r_gen" en UNIDAD_RECURSO es:
     *
     *  - PROPORCION_MAYOR% probabilidades => ultra: animo, RRPP: influencias, empresario: dinero 
     *  - PROPORCION_INTERMEDIA% probabilidades => ultra: dinero, RRPP: animo, empresario: influencias
     *  - PROPORCION_MENOR% probabilidades => ultra: influencias, RRPP: dinero, empresario: animo
     *
     * 3) Se aumentaran los "r_max" cada FRECUENCIA_NIVELES niveles dependiendo del personaje y las constantes:
     *
     *  - ANIMADORA_UNIDAD_INFLUENCIAS_MAX
     *  - EMPRESARIO_UNIDAD_INFLUENCIAS_MAX;
     *  - ULTRA_UNIDAD_INFLUENCIAS_MAX;
     *  - ANIMADORA_UNIDAD_ANIMO_MAX; 
     *  - EMPRESARIO_UNIDAD_ANIMO_MAX;
     *  - ULTRA_UNIDAD_ANIMO_MAX;
     *  
     * @param int $nivel_inicial    nivel de partida del jugador
     * @param int $nivel_actual     nivel que alcanza el jugador
     *
     * @return object[]             nuevos atributos calculados
     */
    public function actualizarAtributos($nivel_inicial, $nivel_actual)
    {
        $niveles_subidos = $nivel_actual - $nivel_inicial;

        /* Valores iniciales de los atributos */
        $atributos['dinero_gen'] =      $this->recursos->dinero_gen;
        $atributos['animo_gen'] =       $this->recursos->animo_gen;
        $atributos['influencias_gen'] = $this->recursos->influencias_gen;
        $atributos['animo_max'] =       $this->recursos->animo_max;
        $atributos['influencias_max'] = $this->recursos->influencias_max;
        $atributos['influencias_bloqueadas'] = $this->recursos->influencias_bloqueadas;

        while ($niveles_subidos > 0) {
            /* generacion de los r_gen */
            for ($i = 1; $i <= self::AUMENTOS_POR_NIVEL; $i++) {
                $atributo = Usuarios::queAtributo($this->personaje);

                if ($atributo == 'dinero_gen') {
                    $cantidad = self::UNIDAD_DINERO_GEN;
                } else if ($atributo == 'animo_gen') {
                    $cantidad = self::UNIDAD_ANIMO_GEN;
                } else if ($atributo == 'influencias_gen') {
                    $cantidad = self::UNIDAD_INFLUENCIAS_GEN;
                }

                $atributos[$atributo] = $atributos[$atributo] + $cantidad; 
            }

            /* generacion de los r_max */
            if ( ($nivel_actual - $niveles_subidos) % self::FRECUENCIA_NIVELES == 0){
                $cuantoSubirMaximos = Usuarios::cuantoSubirMaximos($this->personaje);
                $atributos['influencias_max'] += $cuantoSubirMaximos['influencias_max'];
                $atributos['animo_max'] += $cuantoSubirMaximos['animo_max'];
            }
            $niveles_subidos -= 1;
        }
        return $atributos;
    }

    /**
     * Determina cuanto subir los atributos maximos
     *
     * Se basa unicamente en el tipo de personaje. Fija:
     * 
     *  - influencias_max
     *  - ainmo_max
     *
     * @static
     * @param int $personaje    tipo de personaje 
     * @return object[]         cantidad a subir los atributos maximos
    */
    private static function cuantoSubirMaximos($personaje)
    {
        switch ($personaje) {
            case self::PERSONAJE_ULTRA: 
                return(array(
                    'influencias_max'=>self::ULTRA_UNIDAD_INFLUENCIAS_MAX,
                    'animo_max'=>self::ULTRA_UNIDAD_ANIMO_MAX
                ));
            case self::PERSONAJE_MOVEDORA:
                return (array(
                    'influencias_max'=>self::ANIMADORA_UNIDAD_INFLUENCIAS_MAX,
                    'animo_max'=>self::ANIMADORA_UNIDAD_ANIMO_MAX
                ));
            case self::PERSONAJE_EMPRESARIO:
                return (array(
                    'influencias_max'=>self::EMPRESARIO_UNIDAD_INFLUENCIAS_MAX,
                    'animo_max'=>self::EMPRESARIO_UNIDAD_ANIMO_MAX
                    ));
            default:
                // No deberiamos llegar a este punto
                return (array(
                    'influencias_max'=>self::EMPRESARIO_UNIDAD_INFLUENCIAS_MAX,
                    'animo_max'=>self::ANIMADORA_UNIDAD_ANIMO_MAX
                ));
        }
    }

    /** 
     * Dado un personaje, determina que atributo de generacion aumentar
     *
     * @static
     * @param int $personaje    tipo de personaje
     * @return string           el nombre del atributo a aumentar
     */
    private static function queAtributo($personaje)
    {

        /* generacion de las proporciones 
            [----------------Mayor-------media---menor]
            [--------------------|-----------|--------]
        */
        $p_mayor = self::PROPORCION_MAYOR;
        $p_media = $p_mayor + self::PROPORCION_INTERMEDIA;
        $p_menor = $p_media + self::PROPORCION_MENOR;
        
        /* Determinar segun el personaje que atributo aumentar */
        $aleatorio = rand(0,100);
        if ($aleatorio > $p_media ){
            /* atributo MENOR */
            switch ($personaje) {
                case Usuarios::PERSONAJE_ULTRA: return 'influencias_gen';     
                case Usuarios::PERSONAJE_MOVEDORA: return 'dinero_gen';
                case Usuarios::PERSONAJE_EMPRESARIO: return 'animo_gen';
                default: return 'dinero_gen'; // no deberiamos llegar aqui
            }
        } else if ($aleatorio > $p_mayor) {
            /* atributo MEDIO */
            switch ($personaje) {
                case Usuarios::PERSONAJE_ULTRA: return 'dinero_gen';
                case Usuarios::PERSONAJE_MOVEDORA: return 'animo_gen';
                case Usuarios::PERSONAJE_EMPRESARIO: return 'influencias_gen';
                default: return 'dinero_gen'; // no deberiamos llegar aqui
            }
        } else {
            /* atributo MAYOR */
            switch ($personaje) {
                case Usuarios::PERSONAJE_ULTRA: return 'animo_gen';
                case Usuarios::PERSONAJE_MOVEDORA: return 'influencias_gen';
                case Usuarios::PERSONAJE_EMPRESARIO: return 'dinero_gen';
                default: return 'dinero_gen'; // no deberiamos llegar aqui
            }
        }
    }

    /**
    * Dado un id de una habilidad comprueba si esa habilidad está desbloqueada para el usuario
    *
    * @param int $habilidad               id de la habilidad
    * @return boolean $desbloqueada       true si la habilidad está desbloqueada por el usuario, false si no está desbloqueada
    */
    public function estaDesbloqueada($habilidad){
        $habilidadesDesbloqueadas = Desbloqueadas::model()->findAllByAttributes(array('usuarios_id_usuario'=>$this->id_usuario));

        $desbloqueada = false;

        foreach($habilidadesDesbloqueadas as $d){
            if ($d->habilidades_id_habilidad == $habilidad){
                $desbloqueada = true;
            }
        }

        return $desbloqueada;
    }

    /**
     * Fija los atributos de un nuevo personaje y lo guarda en la base de datos
     *
     * Para un personaje fija:
     *
     * - Recursos iniciales en funcion del personaje escogido
     * - nivel inicial (1)
     * - experencia inicial (0)
     * - puntos de desbloqueo de habilidades (3)
     *
     * @return void
     */
    public function crearPersonaje()
    {
        /* Nivel y Exp */
        $this->setAttributes(array('nivel'=>1, 'exp'=>0, 'puntos_desbloqueo'=>3));
        $this->setAttributes(array('exp_necesaria'=> Usuarios::expNecesaria(1)));
        
        /* Recursos */
        $rec=new Recursos();
        $rec->setAttributes(array('usuarios_id_usuario'=>$this->id_usuario));
        
        switch ($this->personaje) {
            case self::PERSONAJE_ULTRA:
                $rec->setAttributes(array(
                    'dinero'=>self::ULTRA_DINERO_INICIO, 
                    'dinero_gen'=>self::ULTRA_DINERO_GEN_INICIO,
                    'influencias'=>self::ULTRA_INFLUENCIAS_MAX_INICIO,
                    'influencias_max'=>self::ULTRA_INFLUENCIAS_MAX_INICIO,
                    'influencias_gen'=>self::ULTRA_INFLUENCIAS_GEN_INICIO,
                    'influencias_bloqueadas'=>0,
                    'animo'=>self::ULTRA_ANIMO_MAX_INICIO,
                    'animo_max'=>self::ULTRA_ANIMO_MAX_INICIO,
                    'animo_gen'=>self::ULTRA_ANIMO_GEN_INICIO
                ));
            break;
            case self::PERSONAJE_MOVEDORA: 
                $rec->setAttributes(array(
                    'dinero'=>self::ANIMADORA_DINERO_INICIO, 
                    'dinero_gen'=>self::ANIMADORA_DINERO_GEN_INICIO,
                    'influencias'=>self::ANIMADORA_INFLUENCIAS_MAX_INICIO,
                    'influencias_max'=>self::ANIMADORA_INFLUENCIAS_MAX_INICIO,
                    'influencias_gen'=>self::ANIMADORA_INFLUENCIAS_GEN_INICIO,
                    'influencias_bloqueadas'=>0,
                    'animo'=>self::ANIMADORA_ANIMO_MAX_INICIO,
                    'animo_max'=>self::ANIMADORA_ANIMO_MAX_INICIO,
                    'animo_gen'=>self::ANIMADORA_ANIMO_GEN_INICIO
                ));
                break;
            case self::PERSONAJE_EMPRESARIO: 
                $rec->setAttributes(array(
                    'dinero'=>self::EMPRESARIO_DINERO_INICIO, 
                    'dinero_gen'=>self::EMPRESARIO_DINERO_GEN_INICIO,
                    'influencias'=>self::EMPRESARIO_INFLUENCIAS_MAX_INICIO,
                    'influencias_max'=>self::EMPRESARIO_INFLUENCIAS_MAX_INICIO,
                    'influencias_gen'=>self::EMPRESARIO_INFLUENCIAS_GEN_INICIO,
                    'influencias_bloqueadas'=>0,
                    'animo'=>self::EMPRESARIO_ANIMO_MAX_INICIO,
                    'animo_max'=>self::EMPRESARIO_ANIMO_MAX_INICIO,
                    'animo_gen'=>self::EMPRESARIO_ANIMO_GEN_INICIO
                ));
            break; 
            default: break;
        }
        $rec->setAttributes(array('ultima_act'=> time()));
        $rec->save();
        $this->save();
    }

}
