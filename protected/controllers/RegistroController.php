<?php

/**
 * Pagina de registro  
 */
class RegistroController extends Controller
{
	/**
	 * Muestra el formulario para registrarse en la pagina
	 * Si hay datos en $_POST procesa el formulario 
	 * y guarda en la tabla <<usuarios>> el nuevo usuario 
	 *
	 * @ruta 		jugadorNum12/registro
	 * @redirige	juagdorNum12/usuarios/perfil 
	 */
	public function actionIndex()
	{
		/* ALEX */
		$equipos = Equipos::model()->findAll();
		$modelo = new Usuarios ;
		$modelo->scenario='registro';
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if (isset($_POST['Usuarios'])) 
		{
			//cojo datos del formulario
			$nombre=$_POST['Usuarios']['nuevo_nick'];
			$clave=$_POST['Usuarios']['nueva_clave1'];
			$correo=$_POST['Usuarios']['nueva_email1'];
			$modelo->attributes=$_POST['Usuarios'];
			//modifico modelo
			$modelo->setAttributes(array('nick'=>$nombre));
			$modelo->setAttributes(array('pass'=>$clave));
			$modelo->setAttributes(array('email'=>$correo));
			$modelo->setAttributes(array('nivel'=>0));


			$modelo->setAttributes(array('equipos_id_equipo'=>1));
			$modelo->setAttributes(array('personaje'=>1));
			
			if ($modelo->save())
			{
				 $this->redirect(array('site/login'));
			}
		}
		$this->render('index',array('modelo'=>$modelo , 'equipos'=>$equipos) );
	}
	

	/**
	 * @return array de filtros para actions
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

	/**
	 * Especifica las reglas de control de acceso.
	 * Esta función es usada por el filtro "accessControl".
	 * @return array con las reglas de control de acceso
	 */
	/*public function accessRules()
	{
		return array(
			array('allow', // Permite realizar a los usuarios autenticados cualquier acción
				'users'=>array(''),
			),
			array('deny',  // Niega acceso al resto de usuarios
				'users'=>array('*'),
			),
		);
	}*/
}