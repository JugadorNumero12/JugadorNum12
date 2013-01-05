<?php

/* Pagina de usuario, comprende:
 *   perfil del personaje
 *   cuenta de usuario
 */
class UsuariosController extends Controller
{
	/**
	 * @return array de filtros para actions
	 */
	public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Esta función es usada por el filtro "accessControl".
	 * @return array con las reglas de control de acceso
	 */
	public function accessRules()
	{
		return array(
			array('allow', // Permite realizar a los usuarios autenticados cualquier acción
				'users'=>array('@'),
			),
			array('deny',  // Niega acceso al resto de usuarios
				'users'=>array('*'),
			),
		);
	}

    /**
     * Redirige al perfil del usuario
     *
     * @ruta        jugadorNum12/usuarios
     * @redirige    jugadorNum12/usuarios/perfil 
     */
    public function actionIndex()
    {
        /* ROBER */
        $this-> redirect(array('usuarios/perfil'));
    }

    /*
     * Muestra los datos del personaje 
     *   Nick del jugador 
     *   Tipo del personaje
     *   Nivel del personaje
     *   Aficion a la que pertenece
     *   Recursos del personaje
     *   Valores de control de recursos
     *   Habilidades pasivas desbloqueadas 
     *
     * Los datos del usuario se recogen de la variable de sesion
     *
     * @ruta jugadorNum12/usuarios/perfil
     */
    public function actionPerfil()
    {
        /* MARINA */
        /* Nota: la vista tendra variables */
        
        //Busco el id del usuario actual y saco los datos el usuario
        $id= Yii::app()->user->usIdent;
        $modeloUsuario = Usuarios:: model()->findByPk($id); 

        //Saco los datos del equipo del usuario
        $idEquipo = $modeloUsuario->equipos_id_equipo;
        $modeloEquipo = Equipos:: model()->findByPk($idEquipo);

        //Saco los datos de los recursos del usuario
        $modeloRecursos = Recursos:: model()->findByAttributes(array('usuarios_id_usuario'=>$id));

        //Saca la lista de las acciones desbloqueadas por el usuario
        $modeloDesbloqueadas = Desbloqueadas:: model()->findAllByAttributes(array('usuarios_id_usuario'=>$id));
        
        //Prepara los datos de las acciones. Solo queremos enseñar las habilidades pasivas
        $accionesPas = array();
        //$accionDes = Habilidades::model()->findAllByAttributes(array('id_habilidad' => $habilidad['habilidades_id_habilidad']));

        foreach ($modeloDesbloqueadas as $desbloqueada){
            $infoDesbloqueada = Habilidades::model()->findAllByAttributes(array('id_habilidad' => $desbloqueada->habilidades_id_habilidad));
            if ($infoDesbloqueada[0]['tipo'] == Habilidades::TIPO_PASIVA ) {
                $accionesPas[] = $infoDesbloqueada[0]['nombre'];
            }
        }

        $this->render('perfil',array('modeloU'=>$modeloUsuario,
                                      'modeloE'=>$modeloEquipo,
                                      'modeloR'=>$modeloRecursos,
                                      'accionesPas'=>$accionesPas) );
    }

    /*
     * Muestra los datos del personaje de otro usuario
     *  Nick del jugador
     *  Tipo del personaje
     *  Nivel del personaje
     *  Aficion a la que pertenece
     *
     * @parametro   id del usuario que se consulta
     * @ruta        jugadorNum12/usuarios/ver/{$id}
     */
    public function actionVer($id_usuario)
    {
        /* MARINA */ 
        // Nota: la vista tendra variables

         //Saco los datos el usuario pedido
        $modeloUsuario = Usuarios:: model()->findByPk($id_usuario); 

        //Saco los datos del equipo del usuario
        $idEquipo = $modeloUsuario->equipos_id_equipo;
        $modeloEquipo = Equipos:: model()->findByPk($idEquipo);
       
        $this->render('ver',array('modeloU'=>$modeloUsuario,
                                      'modeloE'=>$modeloEquipo));
    
    }

    /*
     * Muestra los datos de la cuenta del usuario
     *  Nick
     *  eMail
     *
     * El id del usuario se recoge de la variable de sesion
     * 
     * @ruta    jugadorNum12/usuarios/cuenta
     */
    public function actionCuenta()
    {
        /* ALEX */
        $id= Yii::app()->user->usIdent;
        $modelo = Usuarios:: model()->findByPk($id);
        $this->render('cuenta',array('modelo'=>$modelo));
    }

    /*
     * Muestra un formulario para cambiar la clave del usuario
     * Si hay datos en $_POST procesa el formulario y guarda la
     * nueva clave en la tabla <<usuarios>> 
     *
     * @ruta        jugadorNum12/usuarios/cambiarClave
     * @redirige    jugadorNum12/usuarios/cuenta
     */
    public function actionCambiarClave()
    {
        /* ROBER */
        $id= Yii::app()->user->usIdent;        
        $modelo = Usuarios:: model()->findByPk($id);
        $modelo->scenario='cambiarClave';

        if (isset($_POST['Usuarios'])) 
        {
            //Cojo la clave de post(formulario)       
            $clave=$_POST['Usuarios']['nueva_clave1'];
            $modelo->attributes=$_POST['Usuarios'];
            //Modifico dentro del modelo su pass     
            $modelo->setAttributes(array('pass'=>$clave));             
            //Si es valido, se guarda y redirecciono a su cuenta
            //Sino es correcto, mensaje de error
            if ($modelo->save()) 
            { 
                $this->redirect(array('usuarios/cuenta'));
            }
           
        }
            $this->render('cambiarClave',array('model'=>$modelo));            
    }

    /*
     * Muestra un formulario para cambiar el eMail del usuario
     * Si hay datos en $_POST procesa el formulario y guarda el  
     * nuevo email en la tabla <<usuarios>> 
     *
     * @ruta        jugadorNum12/usuarios/cambiarEmail
     * @redirige    jugadorNum12/usuarios/cuenta
     */
    public function actionCambiarEmail()
    {
        /* ROBER */
        // Nota: el email es unico para cada usuario
        //Hay que realizar una transaccion por si dos usuarios guardan al mismo tiempo el email
        //ya que les daria que son validos y no es asi 

        $trans=Yii::app()->db->beginTransaction();

        try
        {
            //Realizo la comprobacion de si el email es único en su modelo, mediante rules()
            $id= Yii::app()->user->usIdent;        
            $modelo = Usuarios:: model()->findByPk($id);
            $modelo->scenario='cambiarEmail';

            if (isset($_POST['Usuarios'])) 
            {
                //Cojo la clave de post(formulario)       
                $email=$_POST['Usuarios']['nueva_email1'];
                $modelo->attributes=$_POST['Usuarios'];
                //Modifico dentro del modelo su pass        
                $modelo->setAttributes(array('email'=>$email));
                //Si es valido, se guarda y redirecciono a su cuenta
                //Sino es correcto, mensaje de error
                if ($modelo->save()) 
                {
                   $trans->commit();
                   $this->redirect(array('usuarios/cuenta'));
                }else
                {
                    $trans->commit(); 
                }               
            }
        }catch (Exception $e)
                {
                    $trans->rollBack();
                }               
        $this->render('cambiarEmail',array('model'=>$modelo));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Usuarios::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        /*Para el formulario de cambiarClave*/
        if(isset($_POST['ajax']) && $_POST['ajax']==='clave-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        /*Para el formulario de cambiarEmail*/
        if(isset($_POST['ajax']) && $_POST['ajax']==='email-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
