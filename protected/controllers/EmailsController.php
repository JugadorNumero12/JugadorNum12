<?php

/**
 * Funcionalidad de la mensajeria
 *
 *
 * @package controladores
 */
class EmailsController extends Controller
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
	 * Muestra la bandeja de entrada del usuario
	 *
	 * @route  jugadorNum12/emails
     * @return void
	 */
	public function actionIndex()
    {
		$niks = array();
		//Saca todos los emails recibidos por el usuario y que no los haya borrado
		$sql = "SELECT * FROM  emails WHERE (id_usuario_to =".Yii::app()->user->usIdent." AND leido =0 AND borrado_to =0) ORDER BY fecha DESC";
		$emails = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($emails as $i=>$email){
			$usuario=Usuarios::model()->findByPk($email['id_usuario_from']);
			$niks[$i] = $usuario->nick;
		}
		$this->render('index',array('emails'=>$emails,'niks'=>$niks));
	}

	/**
	 * Muestra el formulario para redactar un email junto con una lista de usuarios
	 *
     * @param string $destinatario  nick del destinatario del mensaje
     * @param string $tema          asunto del email
     *
	 * @route      jugadorNum12/emails/redactar/{$destinatario}/{$tema}
	 * @redirect   juagdorNum12/emails
     *
     * @return     void
	 */
	public function actionRedactar($destinatario, $tema)
    {
		$yo = Usuarios::model()->findByAttributes(array('id_usuario'=>Yii::app()->user->usIdent));
		$mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$yo->equipos_id_equipo));
		$des="";

		$email = new Emails;
		if(isset($_POST['Emails'])){
			$email->scenario='redactar';			

			$destinatarios = $_POST['Emails']['nombre'];
			$des = $email->sacarUsuarios($destinatarios);
			foreach ($des as $destinatario) {
				$emailAux = new Emails;
				$emailAux->scenario='redactar';
				$trans = Yii::app()->db->beginTransaction();
				try{
					$emailAux->attributes=$_POST['Emails']; //asunto y contenido
					$emailAux->setAttributes(array('id_usuario_from'=>$yo->id_usuario)); //remitente
					$emailAux->setAttributes(array('fecha'=>time()));//fecha
					$para = Usuarios::model()->findByAttributes(array('nick'=>$destinatario));
					if($para === null) throw new CHttpException( 404, 'Usuario inexistente');
					$emailAux->setAttributes(array('id_usuario_to'=>$para->id_usuario));//destinatario
					if($emailAux->save()){
						$trans->commit();
						
					}

				}catch(Exception $e){
					$trans->rollback();
				}				
			}
			$this->redirect(array('index'));			
		}
		$this->render('redactar',array('email'=>$email,'mi_aficion'=>$mi_aficion, 'destinatario'=>$destinatario , 'tema'=>$tema, 'des'=>$des));

	}

	/**
	 * Muestra un email
	 *
     * @param int $id   id del email a leer
     *
	 * @route  jugadorNum12/emails/leerEmail/{$id}
     * @return void
	 */
	public function actionLeerEmail($id)
    {
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
     * @param int $id       id del email a eliminar
     * @param string $antes determina donde redireccionaremos.
     *    
	 * @route       jugadorNum12/emails/eliminarEmail/{$id}/{$antes} 
     * @redirect    jugadorNum12/emails/index   si $antes == 'entrada'
     * @redirect    jugadorNum12/email/enviados en caso contrario
     *
     * @return void
	 */ 
	public function actionEliminarEmail($id,$antes)
    {
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
	 * @route jugadorNum12/emails/enviados
     * @return void
	 */
	public function actionEnviados()
    {
		$niks = array();
		//saca todos los emails enviados por el usuario y que no los haya borrado
		$sql = "SELECT * FROM  emails WHERE (id_usuario_from =".Yii::app()->user->usIdent." AND borrado_from =0) ORDER BY fecha DESC";
		$emails = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($emails as $i=>$email){
			$usuario=Usuarios::model()->findByPk($email['id_usuario_to']);
			$niks[$i] = $usuario->nick;
		}
		$this->render('enviados',array('emails'=>$emails,'niks'=>$niks));
	}

	/**
	 * Enviar un mensaje a toda la aficion.
     *
     * > obtiene el listado de nicks de todos los jugadores de una misma aficion separados por ","
	 *
	 * @param int $id_equipo   id del equipo al que se va a mandar el mensaje
     * 
     * @route       jugadorNum12/email/mensajeEquipo/{$id_equipo}
	 * @redirect 	jugadorNum12/email/redactar
     * @return      void
	 */
	public function actionMensajeEquipo($id_equipo)
    {
		//coje a todos los jugadores de ese equipo
		$mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$id_equipo));

		$destinatarios = "";
		//Para cada jugador del equipo lo guarda en el string de envio
		foreach ($mi_aficion as $jugador) {
			$destinatarios.=$jugador->nick.",";
		}

		$this->redirect(array('emails/redactar/','destinatario'=>$destinatarios, 'tema'=>""));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
}
