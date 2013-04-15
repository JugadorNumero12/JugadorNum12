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
	 * @ruta jugadorNum12/emails/redactar
	 * @redirige juagdorNum12/emails
	 */
	public function actionRedactar($destinatario, $tema, $equipo){        
        
        $trans = Yii::app()->db->beginTransaction();
		$yo = Usuarios::model()->findByAttributes(array('id_usuario'=>Yii::app()->user->usIdent));
		$mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$yo->equipos_id_equipo));
		if($equipo == true){
			$destinatario = "";
			foreach($mi_aficion as $amigo){
				$destinatario.=$amigo->nick.",";
			}
		}
		$email = new Emails;
        $email->scenario='redactar';

        if (isset($_POST['Emails'])) 
        {
            $co = $_POST['Emails']['contenido'];
			$as = $_POST['Emails']['asunto'];
			$no = $_POST['Emails']['nombre'];
			$dests = Emails::model()->sacarUsuarios($no);
			
			foreach($dests as $dest){
				$usr_dest = Usuarios::model()->findByAttributes(array('nick'=>$dest));
				if($usr_dest!=null){
					$mail = new Emails;
					$mail->fecha = time();
					$mail->asunto = $as;
					$mail->contenido = $co;
					$mail->id_usuario_to = $usr_dest->id_usuario;
					$mail->id_usuario_from = $yo->id_usuario;
					if(!$mail->save())
						$this->render('redactar',array('email'=>$email,'mi_aficion'=>$mi_aficion, 'destinatario'=>$destinatario , 'tema'=>$tema));		
				}
				$email = new Emails;
			}
			$trans->commit();
        	$this->redirect(array('index')); 
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
	 * Al mandar un mensaje a toda la aficion saca los nombres de todos los de tu equipo para mandar el mensaje
	 *
	 * @parametro 	id del equipo al que se va a mandar el mensaje
	 * @redirige 	jugadorNum12/email/redactar
	 */
/*	public function actionMensajeEquipo($id_equipo){

		//coje a todos los jugadores de ese equipo
		$mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$id_equipo));

		$destinatarios = "";
		//Para cada jugador del equipo lo guarda en el string de envio
		foreach ($mi_aficion as $jugador) {
			$destinatarios.=$jugador->nick.",";
		}

		$this->redirect(array('emails/redactar/','destinatario'=>$destinatarios, 'tema'=>""));

	}*/

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
