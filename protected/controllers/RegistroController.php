<?php

/**
 * Pagina de registro  
 */
class RegistroController extends Controller
{
	/**
	 * Muestra el formulario para registrarse en la pagina
	 * Si hay datos en $_POST procesa el formulario 
	 * y guarda en la tabla usuarios un nuevo usuario a traves del modelo Usuarios 
	 *
	 * @route jugadorNum12/registro
	 */
	public function actionIndex()
	{
		/*  TODO codigo similar a:
		
			$model=new Usuarios;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Usuarios']))
			{
				$model->attributes=$_POST['Usuarios'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id_usuario));
			}

			$this->render('create',array(
				'model'=>$model,
			));
		*/

		/* TODO programar la vista */
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