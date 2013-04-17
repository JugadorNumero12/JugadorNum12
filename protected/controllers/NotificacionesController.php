<?php

/** 
 * Controlador de las notificaciones
 *
 *
 * @package controladores
 */
class NotificacionesController extends Controller
{
    /**
    * Definicion del verbo DELETE unicamente via POST
    *
    * > Funcion predeterminada de Yii
    *
    * @return string[]     filtros definidos para "actions"
    */
    public function filters()
    {
        return array('accessControl', 'postOnly + delete');
    }

    /**
     * Especifica las reglas de control de acceso.
     * 
     *  - Permite realizar a los usuarios autenticados cualquier accion
     *  - Niega el acceso al resto de usuarios
     *
     * > Funcion predeterminada de Yii 
     *
     * @return object[]     reglas usadas por el filtro "accessControl"
     */
	public function accessRules()
	{
		return array(
			array('allow', 'users'=>array('@')),
			array('deny', 'users'=>array('*')),
		);
	}

	/**
	 * Muestra las notificaciones
	 *
	 * @route jugadorNum12/notificaciones
	 * @return void
	 */
	public function actionIndex()
	{
		$misUsrnotif = Usrnotif::model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent, 'leido'=>0));
		$notificaciones = array();
		foreach ($misUsrnotif as $usrnotif) {
			$notificacion = Notificaciones::model()->findByPK($usrnotif['notificaciones_id_notificacion']);
			if ($notificacion === null)
				Yii::app()->user->setFlash('notificaion', 'Notificacion no encontrada.');
			$notificaciones[] = array('notificacion'=>$notificacion,'leido'=>$usrnotif->leido);
		}
		$this->render('index',array('notificaciones'=>$notificaciones));
	}

	/**
	 * Leer una notificacion: Cambia el estado de la notificación a leida
	 *
	 * @param int $id 		id de la notificacion
	 * @param string $url 	direccion de retorno una vez leida la notificacion
	 *
	 * @route jugadorNum12/notificaciones/leer/{$id}/{$url}
	 * @redirect {$url}
	 *
	 * @return void
	 */
	public function actionLeer($id , $url)
	{
		$usrnotif = Usrnotif::model()->findByAttributes(array('usuarios_id_usuario' => Yii::app()->user->usIdent,'notificaciones_id_notificacion' => $id));	
		if($usrnotif === null || $usrnotif->leido == 1) {
			Yii::app()->user->setFlash('error', 'Notificacion inexistente o ya leida.');
		}
		
		$trans = Yii::app()->db->beginTransaction();
		try {
			$usrnotif->leido = !$usrnotif->leido;
			if($usrnotif->save()){
				$trans->commit();
			}
		} catch(Exception $e) {
			$trans->rollback();
		}
		
		$this->redirect(array($url));
	}

    /**
     * Devuelve el modelo de datos basado en la clave primaria dada por la variable GET 
     *
     * > Funcion predeterminada de Yii
     * 
     * @param int $id            id del modelo que se va a cargar 
     * @throws \CHttpException   El modelo de datos no se encuentra 
     * @return \AccionesGrupales modelo de datos
     */
	public function loadModel($id)
	{
		$model=Emails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    /**
     * Realiza la validacion por Ajax 
     *
     * > Funcion predeterminada de Yii
     * 
     * @param $model (CModel) modelo a ser validado
     * @return void
     */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notificacion-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
