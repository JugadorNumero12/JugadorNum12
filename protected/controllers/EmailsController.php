<?php

/**
 * Controlador de la mensajeria
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
		$sql = "SELECT * FROM  emails WHERE (id_usuario_to =".Yii::app()->user->usIdent." AND borrado_to =0) ORDER BY fecha DESC";
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
	/**
	 * Muestra la formulario para redactar un email junto con una lista de usuarios
	 *
	 * @ruta jugadorNum12/emails/redactar
	 * @redirige juagdorNum12/emails
	 */
	public function actionRedactar($destinatario, $tema)
	{                
        $trans = Yii::app()->db->beginTransaction();
		$yo = Usuarios::model()->findByAttributes(array('id_usuario'=>Yii::app()->user->usIdent));
		$nombre_usuario=$yo->nick;

		$email = new Emails;
        $email->scenario='redactar';

        $this->performAjaxValidation($email);

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
		$this->render('redactar',array('email'=>$email,'destinatario'=>$destinatario , 'tema'=>$tema, 'nombre_usuario'=>$nombre_usuario));
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
		if($from == (Usuarios::model()->findByPk(Yii::app()->user->usIdent)->nick))
			$borrado = "borrado_from";
		else
			$borrado = "borrado_to";
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
		$this->render('leerEmail',array('email'=>$email,'from'=>$from,'to'=>$to, 'borrado'=>$borrado));
	}

	/**
	 * Elimina emails
	 *
     * @param int $id       id del email a eliminar o 0 si se quieren eliminar todos
     * @param string $borrado determina donde redireccionaremos y si se borra de la bandeja del remitente o del destinatario.
     *    
	 * @route       jugadorNum12/emails/eliminarEmails/{$id}/{$borrado} 
     * @redirect    jugadorNum12/emails/index   si $borrado == 'borrado_to'
     * @redirect    jugadorNum12/email/enviados en caso contrario
     *
     * @return void
	 */ 
	public function actionEliminarEmails($id,$borrado)
    {
		if($id != 0){
			$email = Emails::model()->findByPk($id);
			if($email === null) Yii::app()->user->setFlash('inexistente', 'Email inexistente.');
			$emails = array('email'=>$email);
		}else{
			if($borrado == 'borrado_to')
				$emails = Emails::model()->findAllByAttributes(array('id_usuario_to'=>Yii::app()->user->usIdent, $borrado=>0));
			else
				$emails = Emails::model()->findAllByAttributes(array('id_usuario_from'=>Yii::app()->user->usIdent, $borrado=>0));
		}
		$trans = Yii::app()->db->beginTransaction();
		try{
			foreach($emails as $email){
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
			}
			$trans->commit();
			if($borrado == 'borrado_to') $this->redirect(array('emails/index'));
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
   * Al mandar un mensaje a toda la aficion saca los nombres de todos los de tu equipo para mandar el mensaje
   *
   * @parametro   id del equipo al que se va a mandar el mensaje
   * @redirige   jugadorNum12/email/redactar
   */
  public function actionMensajeEquipo($id_equipo){

    //coje a todos los jugadores de ese equipo
    $mi_aficion = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$id_equipo));

    $destinatarios = "";
    //Para cada jugador del equipo lo guarda en el string de envio
    foreach ($mi_aficion as $jugador) {
    	if($jugador->id_usuario != Yii::app()->user->usIdent){
      		$destinatarios.=$jugador->nick.",";
      	}
    }
    $destinatarios = substr($destinatarios, 0, -1);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='emails-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
