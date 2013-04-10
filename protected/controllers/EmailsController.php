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
		$niks = array();
		//Saca todos los emails recibidos por el usuario y que no los haya borrado
		$emails = Emails::model()->findAllByAttributes(array('id_usuario_to'=>Yii::app()->user->usIdent,'borrado_to'=>0));
		foreach ($emails as $i=>$email){
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
	public function actionRedactar($destinatario, $tema){
		$trans = Yii::app()->db->beginTransaction();
		$yo = Usuarios::model()->findByAttributes(array('id_usuario'=>Yii::app()->user->usIdent));
		$mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$yo->equipos_id_equipo));
		try{
			$email = new Emails;
			if (isset($_POST['Emails']) ) {
				$email->scenario='redactar';
				$email->attributes=$_POST['Emails']; //asunto y contenido
				$email->setAttributes(array('id_usuario_from'=>$yo->id_usuario)); //remitente
				$email->setAttributes(array('fecha'=>time()));//fecha
				$para = Usuarios::model()->findByAttributes(array('nick'=>$_POST['Emails']['nombre']));
				if($para === null) throw new CHttpException( 404, 'Usuario inexistente');
				$email->setAttributes(array('id_usuario_to'=>$para->id_usuario));//destinatario
				if($email->save()){
					$trans->commit();
					$this->redirect(array('index'));
				}
			}
		}catch(Exception $e){
			$trans->rollback();
		}
		$this->render('redactar',array('email'=>$email,'mi_aficion'=>$mi_aficion, 'destinatario'=>$destinatario , 'tema'=>$tema));
	}

	/**
	 * Muestra un email
	 *
	 * @ruta jugadorNum12/emails/leerEmail
	 */
	public function actionLeerEmail($id){
		$email = Emails::model()->findByPk($id);
		if($email === NULL) Yii::app()->user->setFlash('inexistente', 'Email inexistente.');
		$usuario_from = Usuarios::model()->findByPk($email->id_usuario_from);
		$from = $usuario_from->nick;
		$usuario_to = Usuarios::model()->findByPk($email->id_usuario_to);
		$to = $usuario_to->nick;

		if($email->id_usuario_to == Yii::app()->user->usIdent && !$email->leido){
			$trans = Yii::app()->db->beginTransaction();
			try{
				$email->leido = !$email->leido;
				$email->save();
				$trans->commit();
			}catch(Exception $e){
				$trans->rollback();
			}
		}
		$this->render('leerEmail',array('email'=>$email,'from'=>$from,'to'=>$to));
	}

	/**
	 * Elimina un email
	 *
	 * @ruta jugadorNum12/emails/leerEmail 
	 */ 
	public function actionEliminarEmail($id,$antes){
		$email = Emails::model()->findByPk($id);
		if($email === null) Yii::app()->user->setFlash('inexistente', 'Email inexistente.');
		$trans = Yii::app()->db->beginTransaction();
		try{
			$id_usr= Yii::app()->user->usIdent;
			if(($email->id_usuario_to == $id_usr && $email->borrado_from) || ($email->id_usuario_from == $id_usr && $email->borrado_to) || ($email->id_usuario_from == $id_usr && $email->id_usuario_to == $id_usr )) 
				$email->delete();
			else{
				if($email->id_usuario_to == $id_usr) 
					$email->borrado_to = !$email->borrado_to;
				else 
					$email->borrado_from = !$email->borrado_from;
			}

			$email->save();
			$trans->commit();
			if($antes == 'entrada') $this->redirect(array('emails/index'));
			else $this->redirect(array('emails/enviados'));
		}catch(Exception $e){
			$trans->rollback();
		}		
	}

	/**
	 * Muestra la bandeja de salida del usuario
	 *
	 * @ruta jugadorNum12/emails/enviados
	 */
	public function actionEnviados(){
		$niks = array();
		$emails = Emails::model()->findAllByAttributes(array('id_usuario_from'=>Yii::app()->user->usIdent,'borrado_from'=>0));
		foreach ($emails as $i=>$email){
			$usuario=Usuarios::model()->findByPk($email->id_usuario_to);
			$niks[$i] = $usuario->nick;
		}
		$this->render('enviados',array('emails'=>$emails,'niks'=>$niks));
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
