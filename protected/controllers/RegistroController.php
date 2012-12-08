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
	}

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	
}