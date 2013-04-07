<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/main',
	 * meaning using a single column layout. 
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function beforeAction ($action) {
		if (!parent::beforeAction($action)) {
			return false;
		}

		if (isset(Yii::app()->user->usIdent)) {
			// Obtiene la clasificación de los equipos
			$clasificacion = Clasificacion::model()->with('equipos')->findAll(array('order'=>'posicion ASC'));
			Yii::app()->setParams(array('clasificacion'=>$clasificacion));

			// Obtiene la información del usuario
			$usuario = Usuarios::model()->with('recursos')->findByPK(Yii::app()->user->usIdent);
			Yii::app()->setParams(array('usuario'=>$usuario));

			// Obtiene la información de la mensajeria
			$mensajeria = Emails::model()->with('usuarioTo')->findByPK(Yii::app()->user->usIdent);
			$count = count($mensajeria);
			Yii::app()->setParams(array('count'=>$count));

		}
		
		Yii::app()->setParams(array('bgclass'=>'bg-estadio-fuera'));

		return true;
	}
}