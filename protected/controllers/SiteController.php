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
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// Redireccionar a login
		$this->redirect(array('site/login'));
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
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('usuarios/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Esta acción debería desaparecer en producción
	 */
	public function actionFormula($dn=0, $al=0, $av=0, $ml=0, $mv=0, $ol=0, $ov=0, $dl=0, $dv=0)
	{
		// Creamos el array de parámetros a partir de los datos GET
		$params = array(
 			'difNiv'    => (double) $dn,
 			'aforoLoc'  => (double) $al,
			'aforoVis'  => (double) $av,
			'moralLoc'  => (double) $ml,
			'moralVis'  => (double) $mv,
			'ofensLov'  => (double) $ol,
			'ofensVis'  => (double) $ov,
			'defensLoc' => (double) $dl,
			'defensVis' => (double) $dv,
		);

		// Obtenemos los pesos y las probabilidades de todos los estados
		for ( $i = -9; $i <= 9; $i++ ) {
			$params['estado'] = $i;

			$pesos[$i] = Formula::pesos($params);
			$probs[$i] = Formula::probabilidades($params);
		}

		// Calculamos los colores para la tabla
		foreach ( $probs as $i=>$v ) {
			$max = max($v);
			foreach ( $v as $ii=>$vv ) {
				$r = 255;
				$g = 255 - (int) round($vv*255);
				$b = 255 - (int) round(($vv/$max)*255);
				$colors[$i][$ii] = "rgb($r,$g,$b)";
			}
		}

		// Dibujamos la vista
		unset($params['estado']);
		
		$this->layout = "main";
		$this->render('formula', array(
			'probs'=>$probs,
			'pesos'=>$pesos,
			'colors'=>$colors,
			'params'=>$params
		));

	}
}