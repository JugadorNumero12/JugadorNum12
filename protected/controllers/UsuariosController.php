<?php

/* Pagina de usuario, comprende:
 *   perfil del personaje
 *   cuenta de usuario
 */
class UsuariosController extends Controller
{
    /**
     * Funcion predeterminada de Yii
     * 
     * @return (array) filtros para "actions"
     */
	public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // permitir "delete" solo via POST
		);
	}

    /**
     * Funcion predeterminada de Yii 
     * Especifica las reglas de control de acceso.
     * 
     *  - Permite realizar a los usuarios autenticados cualquier accion
     *  - Niega el acceso al resto de usuarios
     *
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
     * @route jugadorNum12/usuarios
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

    /*
     * Muestra los datos del personaje 
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


        $this->render('perfil',array('modeloU'=>$modeloUsuario, 
                        'accionesPas'=>$accionesPas,
                        'accionesPar'=>$accionesPar,
                        'recursos'=>$recursos) );
    }

    /*
     * Muestra los datos del personaje de otro usuario
     *  Nick del jugador
     *  Tipo del personaje
     *  Nivel del personaje
     *  Aficion a la que pertenece
     *
     * @param $id_usuario
     * @route jugadorNum12/usuarios/ver/{$id}
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
                $this->render('ver',array('modeloU'=>$modeloUsuario)); 
            }
        }   
    }

    /*
     * Muestra un formulario para cambiar la clave del usuario
     * Si hay datos en $_POST procesa el formulario y guarda la
     * nueva clave en la tabla <<usuarios>> 
     *
     * @route jugadorNum12/usuarios/cambiarClave
     * @redirect jugadorNum12/usuarios/perfil
     */
    public function actionCambiarClave()
    {
        /* Actualizar datos de usuario (recuros,individuales y grupales) */
        Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
        /* Fin de actualización */
        
        $id= Yii::app()->user->usIdent;        
        $modelo = Usuarios:: model()->findByPk($id);
        $modelo->scenario='cambiarClave';

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
        
        $this->render('cambiarClave',array('model'=>$modelo));            
    }

    /*
     * Muestra un formulario para cambiar el eMail del usuario
     * Si hay datos en $_POST procesa el formulario y guarda el  
     * nuevo email en la tabla <<usuarios>> 
     *
     * @route jugadorNum12/usuarios/cambiarEmail
     * @redirect jugadorNum12/usuarios/perfil
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
        
        $this->render('cambiarEmail',array('model'=>$modelo));
    }

    /* DEBUG */
    // +500 experencia
    public function actionDebug()
    {
        $id = Yii::app()->user->usIdent;
        $usuario = Usuarios:: model()->findByPk($id);
        
        // transaccion
        $usuario->sumarExp(500);
        // end transaccion

        $this->redirect(array('usuarios/perfil'));
    }
    // + 5000 experencia
    public function actionDebug2()
    {
        $id = Yii::app()->user->usIdent;
        $usuario = Usuarios:: model()->findByPk($id);

        // transaccion
        $usuario->sumarExp(5000);
        // end transaccion

        $this->redirect(array('usuarios/perfil'));
    }
    // Listado de niveles de exp necesarios
    public function actionExp()
    {
        $exp = array(100);
        for($i = 0; $i < 100; $i++) {
            $exp[$i] = Usuarios::expNecesaria($i);
        }
        $this->render('exp', array('array'=>$exp));
    }
    // ejemplos de personajes
    public function actionEjemplos()
    {
        // borramos los personajes de ejemplos de la base de datos
        Yii::app()->db->createCommand('DELETE FROM recursos WHERE usuarios_id_usuario IN
            (SELECT id_usuario from usuarios WHERE email="test@test.com")')->query();
        Yii::app()->db->createCommand('DELETE FROM usuarios WHERE email="test@test.com"')->query();

        $ultras = array();
        $chicas = array();
        $empresarios = array();

            for($i = 0; $i < 50; $i++) {
                $u = new Usuarios(); $e = new Usuarios(); $c = new Usuarios();
                $u->setAttributes( array(
                    'nick'=>"test_ultra".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
                    'personaje'=>Usuarios::PERSONAJE_ULTRA,
                ));
                $c->setAttributes( array(
                    'nick'=>"test_chica".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
                    'personaje'=>Usuarios::PERSONAJE_MOVEDORA,
                ));
                $e->setAttributes( array(
                    'nick'=>"test_empresario".$i,
                    'pass'=>"123456",
                    'equipos_id_equipo'=>1,
                    'email'=>"test@test.com",
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
    /* ** */

    /**
     * Funcion predeterminada de Yii
     * Devuelve el modelo de datos basado en la clave primaria dada por la variable GET
     * Si el modelo de datos no se encuentra, se lanza una excepcion HTTP
     * 
     * @param $id : id del modelo que se va a cargar 
     * @return modelo de datos
     */
    public function loadModel($id)
    {
        $model=Usuarios::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Funcion predeterminada de Yii
     * Realiza la validacion por Ajax
     *
     * @param $model (CModel) modelo a ser validado
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
