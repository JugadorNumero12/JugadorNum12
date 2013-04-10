<?php

class SiteController extends Controller
{
	public $layout='//layouts/login';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			//yii chat
			 'chat'=>array('class'=>'YiiChatAction'),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
     *
     * @redirect    jugadorNum12/usuarios
	 */
	public function actionIndex()
	{
		// Usuario Invitado => Redireccionar a login
		if (Yii::app()->user->isGuest) {
			$this->redirect(array('site/login'));
		} else {
            $this->redirect(array('usuarios/index'));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$modelo=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($modelo);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$modelo->attributes=$_POST['LoginForm'];
			$usuario = Usuarios::model()->findByAttributes(array('nick'=>$modelo->username));

			// Comprobaciones
			if ($usuario !== null) {
				// TODO Comprobación de que el usuario existe
				// Si no existe, no sé qué habría que hacer

				if ($usuario->equipos_id_equipo === null) {
					$this->redirect(array('registro/equipo','id_usuario'=>$usuario->id_usuario));
				} else if ($usuario->personaje === null) {
					$this->redirect(array('registro/personaje','id_usuario'=>$usuario->id_usuario));
				}
			}


			// validate user input and redirect to the previous page if valid
			if($modelo->validate() && $modelo->login())
				$this->redirect(array('usuarios/index'));
		}

		// display the login form
		$this->render('login',array('model'=>$modelo));

	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionChats(){
		$this->render('/chat/index');
	}
}