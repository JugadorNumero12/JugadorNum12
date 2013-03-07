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
			$usuario = Usuarios::model()->with('recursos')->findByPK(Yii::app()->user->usIdent);
			Yii::app()->setParams(array('usuario'=>$usuario));
		}

		return true;
	}
}