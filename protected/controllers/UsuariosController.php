<?php

/* Pagina de usuario, comprende:
 *   perfil del personaje
 *   cuenta de usuario
 */
class UsuariosController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
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
    }
}
