<?php

class EmailsController extends Controller
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
	 * Muestra la bandeja de entrada del usuario
	 *
	 * @ruta jugadorNum12/emails
	 */
	public function actionIndex(){
		$id= Yii::app()->user->usIdent; //id de usuario
		$emails = Emails::model()->findAllByAttributes(array('id_usuario_to'=>$id));
		foreach ($emails as $i=>$email){
			//OJO mirar si nos conviene esto o insertamos los nombres de los usuarios en la tabla
			//tmbn mirar si queremos la lista de los usuarios de su aficion
			$usuario=Usuarios::model()->findByPk($email->id_usuario_from);
			$niks[$i] = $usuario->nick;
		}
		$this->render('index',array('emails'=>$emails,'niks'=>$niks));
	}

	/**
	 * Muestra la formulario para redactar un email junto con una lista de usuarios
	 *
	 * @ruta jugadorNum12/emails/redactar
	 * @redirige juagdorNum12/emails
	 */
	public function actionRedactar(){
		$trans = Yii::app()->db->beginTransaction();
		try{
			if (isset($_POST['Emails']) ) {
				//TODO
			}
		}catch(Exception $e){
			$trans->rollback();
		}
	}

	/**
	 * Muestra un email
	 *
	 * @ruta jugadorNum12/emails/leerEmail
	 */
	public function actionLeerEmail($id){

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Emails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
