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