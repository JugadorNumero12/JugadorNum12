<?php

/**
 * Controlador de usuarios que comprende: perfil del personaje y cuenta de usuario
 *
 * @package controladores
 */
class UsuariosController extends Controller
{
    /**
     * Definicion del verbo DELETE unicamente via POST
     *
     * > Funcion predeterminada de Yii
     *
     * @return string[]     filtros definidos para "actions"
     */
	public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // permitir "delete" solo via POST
		);
	}

    /**
     * Especifica las reglas de control de acceso.
     * 
     *  - Permite realizar a los usuarios autenticados cualquier accion
     *  - Niega el acceso al resto de usuarios
     *
     * > Funcion predeterminada de Yii
     * @return (array) reglas usadas por el filtro "accessControl"
     */
	public function accessRules()
	{
		return array(
			array('allow', 'users'=>array('@')),
			array('deny', 'users'=>array('*')),
		);
	}

    /**
     * Muestra el timeline principal de la pagina
     *
     * Informacion a mostrar
     *  - Equipo del usuario
     *  - Enlace al proximo partido del jugador
     *  - Enlace a crear una nueva habilidad grupal
     *  - Acciones grupales activas del equipo del usuario
     * 
     * @route jugadorNum12/usuarios/index
     * @return void
     */
    public function actionIndex()
    {
        // 1) recogemos id de la sesion
        $idUsuario = Yii::app()->user->usIdent; 
        $idEquipo = Yii::app()->user->usAfic; 

        // 2) actualizar datos de usuario 
        Usuarios::model()->actualizaDatos($idUsuario);

        // 3) obtenemos las acciones grupales del equipo del usuario
        $modeloEquipo = Equipos::model()->with('accionesGrupales');
        $equipo = $modeloEquipo->findByPK($idEquipo);

        // 4) obtenemos el proximo partido
        Yii::import('application.components.Partido');      
        $equipoUsuario = Equipos::model()->findByPk($idEquipo);
        $proximoPartido = $equipoUsuario->sigPartido;
        $primerTurno=Partido::PRIMER_TURNO;
        $ultimoTurno=Partido::ULTIMO_TURNO;

        // *) renderizar la vista
        $this->render( 'index', array(
            'equipo' => $equipo,
            'proximoPartido' => $proximoPartido,
            'primerTurno' => $primerTurno,
            'ultimoTurno' => $ultimoTurno 
        ));
    }

    /**
     * Muestra los datos del personaje 
     *
     *  - Nick del jugador 
     *  - Tipo del personaje
     *  - Nivel del personaje
     *  - Aficion a la que pertenece
     *  - Recursos del personaje
     *  - Valores de control de recursos
     *  - Habilidades pasivas desbloqueadas 
     *
     * Nota: Los datos del usuario se recogen de la variable de sesion
     *
     * @route jugadorNum12/usuarios/perfil
     * @return void
     */
    public function actionPerfil()
    {    
        /* Actualizar datos de usuario (recuros,individuales y grupales) */
        Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
        /* Fin de actualización */
        
        //Busco el id del usuario actual y saco los datos el usuario
        $id= Yii::app()->user->usIdent;
        $modeloUsuario = Usuarios:: model()->findByPk($id); 

        //Saca la lista de las acciones desbloqueadas por el usuario
        $modeloDesbloqueadas = Desbloqueadas:: model()->findAllByAttributes(array('usuarios_id_usuario'=>$id));
        
        //Prepara los datos de las acciones. Solo queremos enseñar las habilidades pasivas y las de partido
        $accionesPas = array();
        $accionesPar = array();
        foreach ($modeloDesbloqueadas as $desbloqueada){
            $infoDesbloqueada = Habilidades::model()->findAllByAttributes(array('id_habilidad' => $desbloqueada->habilidades_id_habilidad));
            if ($infoDesbloqueada[0]['tipo'] == Habilidades::TIPO_PASIVA ) {
                $accionesPas[] = $infoDesbloqueada[0];
            }
            if ($infoDesbloqueada[0]['tipo'] == Habilidades::TIPO_PARTIDO ) {
                $accionesPar[] = $infoDesbloqueada[0];
            }
        }
        //Saco los recursos disponibles del usuario
        $recursos = Recursos::model()->findByPk($id);

        // Cargar css de ver perfil
        //$uri = Yii::app()->request->baseUrl.'/less/infoperfil.less';
        //Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);

        $this->render('perfil',array('modeloU'=>$modeloUsuario, 
                        'accionesPas'=>$accionesPas,
                        'accionesPar'=>$accionesPar,
                        'recursos'=>$recursos) );
    }

    /**
     * Muestra los datos del personaje de otro usuario
     *
     * - Nick del jugador
     * - Tipo del personaje
     * - Nivel del personaje
     * - Aficion a la que pertenece
     *
     * @param int $id_usuario
     * @route jugadorNum12/usuarios/ver/{$id}
     * @redirect jugadorNum12/usuarios/perfil
     * @return void
     */
    public function actionVer($id_usuario)
    {
        /* Actualizar datos de usuario (recuros,individuales y grupales) */
        Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
        /* Fin de actualización */
        
         //Saco los datos el usuario pedido
        $modeloUsuario = Usuarios:: model()->findByPk($id_usuario); 

        if ($modeloUsuario === null) {
            Yii::app()->user->setFlash('usuario', 'Usuario inexistente.');
            //throw new CHttpException( 404, 'El usuario no existe.');
        } else {
            if (Yii::app()->user->usIdent == $id_usuario) {
                $this->redirect(array('usuarios/perfil'));
            } else {      
                // Cargar css de ver perfil
                //$uri = Yii::app()->request->baseUrl.'/less/infoperfil.less';
                //Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);

                $this->render('ver',array('modeloU'=>$modeloUsuario)); 
            }
        }   
    }

    /**
     * Muestra un formulario para cambiar la clave del usuario
     *
     * Si hay datos en $_POST procesa el formulario y guarda la nueva clave en la tabla <<usuarios>> 
     *
     * @route jugadorNum12/usuarios/cambiarClave
     * @redirect jugadorNum12/usuarios/perfil
     * @return void
     */
    public function actionCambiarClave()
    {
        /* Actualizar datos de usuario (recuros,individuales y grupales) */
        Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
        /* Fin de actualización */

        $id= Yii::app()->user->usIdent;        
        $modelo = Usuarios:: model()->findByPk($id);
        $modelo->scenario='cambiarClave';

        $this->performAjaxValidation($modelo);

        if (isset($_POST['Usuarios'])) {
            //Cojo la clave de post(formulario)       
            $clave = $_POST['Usuarios']['nueva_clave1'];
            $modelo->attributes = $_POST['Usuarios'];
            //Modifico dentro del modelo su pass     
            $modelo->cambiarClave($clave);          
            //Si es valido, se guarda y redirecciono a su cuenta
            //Sino es correcto, mensaje de error
            if ($modelo->save()) { 
               $this->redirect(array('usuarios/perfil'));
            }
           
        }

        // Cargar css de cambiar datos
        //$uri = Yii::app()->request->baseUrl.'/less/cambiodatos.less';
        //Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);
        
        // Renderizar vista
        $this->render('cambiarClave',array('model'=>$modelo));            
    }

    /**
     * Muestra un formulario para cambiar el eMail del usuario
     *
     * Si hay datos en $_POST procesa el formulario y guarda el  
     * nuevo email en la tabla <<usuarios>> 
     *
     * @route jugadorNum12/usuarios/cambiarEmail
     * @redirect jugadorNum12/usuarios/perfil
     * @return void
     */
    public function actionCambiarEmail()
    {
        /* Actualizar datos de usuario (recuros,individuales y grupales) */
        Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
        /* Fin de actualización */
        
        // Nota: el email es unico para cada usuario
        //Hay que realizar una transaccion por si dos usuarios guardan al mismo tiempo el email
        //ya que les daria que son validos y no es asi 

        $trans=Yii::app()->db->beginTransaction();

        try {
            //Realizo la comprobacion de si el email es único en su modelo, mediante rules()
            $id= Yii::app()->user->usIdent;        
            $modelo = Usuarios:: model()->findByPk($id);
            $modelo->scenario='cambiarEmail';

            $this->performAjaxValidation($modelo);

            if (isset($_POST['Usuarios'])) {
                //Cojo la clave de post(formulario)       
                $email=$_POST['Usuarios']['nueva_email1'];
                $modelo->attributes=$_POST['Usuarios'];
                //Modifico dentro del modelo su pass        
                $modelo->setAttributes(array('email'=>$email));
                //Si es valido, se guarda y redirecciono a su cuenta
                //Sino es correcto, mensaje de error
                if ($modelo->save()) {
                   $trans->commit();
                   $this->redirect(array('usuarios/perfil'));
                } else {
                    $trans->commit(); 
                }               
            }
        } catch (Exception $e) {
            $trans->rollBack();
        }     
        
        // Cargar css de cambiar datos
        //$uri = Yii::app()->request->baseUrl.'/less/cambiodatos.less';
        //Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);
        
        // Renderizar vista
        $this->render('cambiarEmail',array('model'=>$modelo));
    }

    /* DEBUG */
    /**
     * Incrementa en 500 la experiencia (DEBUG)
     *
     * @route jugadorNum12/usuarios/debug
     * @redirect jugadorNum12/usuarios/perfil
     *
     * @return void
     */
    public function actionDebug()
    {
        $id = Yii::app()->user->usIdent;
        $usuario = Usuarios:: model()->findByPk($id);
        
        // transaccion
        $usuario->sumarExp(500);
        // end transaccion

        $this->redirect(array('usuarios/perfil'));
    }
    
    /**
     * Incrementa en 5000 la experiencia (DEBUG)
     *
     * @route jugadorNum12/usuarios/debug2
     * @redirect jugadorNum12/usuarios/perfil
     *
     * @return void
     */
    public function actionDebug2()
    {
        $id = Yii::app()->user->usIdent;
        $usuario = Usuarios:: model()->findByPk($id);

        // transaccion
        $usuario->sumarExp(5000);
        // end transaccion

        $this->redirect(array('usuarios/perfil'));
    }

    /**
     * Listado de niveles de exp necesarios (DEBUG)
     *
     * @route jugadorNum12/usuarios/exp
     *
     * @return void
     */
    public function actionExp()
    {
        $exp = array(100);
        for($i = 0; $i < 100; $i++) {
            $exp[$i] = Usuarios::expNecesaria($i);
        }
        $this->render('exp', array('array'=>$exp));
    }

    /**
     * ejemplos de personajes(DEBUG)
     *
     * @route jugadorNum12/usuarios/ejemplos
     *
     * @return void
     */
    public function actionEjemplos()
    {
        // borramos los personajes de ejemplos de la base de datos
        Yii::app()->db->createCommand('DELETE FROM recursos WHERE usuarios_id_usuario IN
            (SELECT id_usuario from usuarios WHERE email="test@test.com")')->query();
        Yii::app()->db->createCommand('DELETE FROM usuarios WHERE email="test@test.com"')->query();

        $ultras = array();
        $chicas = array();
        $empresarios = array();

            for($i = 0; $i < 10; $i++) {
                $u = new Usuarios(); $e = new Usuarios(); $c = new Usuarios();
                $u->setAttributes( array(
                    'nick'=>"test_ultra".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
                    'puntos_desbloqueo' => 1,
                    'personaje'=>Usuarios::PERSONAJE_ULTRA,
                ));
                $c->setAttributes( array(
                    'nick'=>"test_chica".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
                    'puntos_desbloqueo' => 1,
                    'personaje'=>Usuarios::PERSONAJE_MOVEDORA,
                ));
                $e->setAttributes( array(
                    'nick'=>"test_empresario".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
                    'puntos_desbloqueo' => 1,
                    'personaje'=>Usuarios::PERSONAJE_EMPRESARIO,
                ));
                $u->save(); $c->save(); $e->save();
                $u->crearPersonaje(); $c->crearPersonaje(); $e->crearPersonaje();
                $u->sumarExp($i*1000); $c->sumarExp($i*1000); $e->sumarExp($i*1000);
                $u->save(); $c->save(); $e->save();
                $ultras[$i] = $u; $chicas[$i] = $c; $empresarios[$i] = $e;
            }
        
        $this->render('ejemplos', array(
            'ultras'=>$ultras,
            'chicas'=>$chicas,
            'empresarios'=>$empresarios
        ));
    }

    /**
     * Funcion predeterminada de Yii
     * Devuelve el modelo de datos basado en la clave primaria dada por la variable GET
     * Si el modelo de datos no se encuentra, se lanza una excepcion HTTP
     * 
     * @param int $id : id del modelo que se va a cargar 
     * @throws \Exception 404 'The requested page does not exist.'
     * @return \Usuarios   modelo de datos
     */
    public function loadModel($id)
    {
        $model=Usuarios::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Realiza la validacion por Ajax
     * > Funcion predeterminada de Yii 
     *
     * @param $model (CModel) modelo a ser validado
     * @return void
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
