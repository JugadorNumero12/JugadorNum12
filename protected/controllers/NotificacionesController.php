<?php

class NotificacionesController extends Controller
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
	 * Muestra las notificaciones
	 *
	 * @ruta jugadorNum12/notificaciones
	 */
	public function actionIndex(){

		$misUsrnotif = Usrnotif::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent, 'leido'=>0));

		$notificaciones = array();
		foreach ($misUsrnotif as $usrnotif){
			$notificacion = Notificaciones::model()->findByPK($usrnotif['notificaciones_id_notificacion']);
			if ($notificacion === null)
				Yii::app()->user->setFlash('notificaion', 'Notificacion no encontrada.');
			$notificaciones[] = array('notificacion'=>$notificacion,'leido'=>$usrnotif->leido);
		}
		$this->render('index',array('notificaciones'=>$notificaciones));
	}

	/**
	 * Cambia el estado de la notificación a leida
	 *
	 * @ruta jugadorNum12/notificaciones
	 */
	public function actionLeer($id , $url){
		$usrnotif = Usrnotif::model()->findByAttributes(array('usuarios_id_usuario' => Yii::app()->user->usIdent,'notificaciones_id_notificacion' => $id));	
		if($usrnotif === null || $usrnotif->leido == 1) Yii::app()->user->setFlash('error', 'Notificacion inexistente o ya leida.');
			$trans = Yii::app()->db->beginTransaction();
			try{
				$usrnotif->leido = !$usrnotif->leido;
				if($usrnotif->save()){
					$trans->commit();
				}
			}catch(Exception $e){
				$trans->rollback();
			}
		$this->redirect(array($url));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='notificacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
