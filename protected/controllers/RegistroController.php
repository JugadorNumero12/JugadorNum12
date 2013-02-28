<?php

/**
 * Pagina de registro  
 */
class RegistroController extends Controller
{
	public $layout='//layouts/registro';
	/**
	 * Muestra el formulario para registrarse en la pagina
	 * Si hay datos en $_POST procesa el formulario 
	 * y guarda en la tabla <<usuarios>> el nuevo usuario 
	 *
	 * @ruta 		jugadorNum12/registro
	 * @redirige	juagdorNum12/usuarios/perfil 
	 */
	public function actionIndex()
	{
		/* ALEX */
		$animadora_status=false;
		$empresario_status=false;
		$ultra_status=false;
		$error = false;
		$equip = Equipos::model()->findAll();
		$equipos[0] = "Elige un equipo";
		foreach ($equip as $equipo){
			$equipos[$equipo['id_equipo']] = $equipo['nombre'];
		}
		$modelo = new Usuarios();
		$seleccionado = 0;
		
		$modelo->scenario='registro';
		$transaction = Yii::app()->db->beginTransaction();
		try{

			if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			if (isset($_POST['Usuarios']) ) {
				$seleccionado = $_POST['ocup'];
				
				$modelo->attributes=$_POST['Usuarios'];
				//modifico modelo con los datos del formulario
				$modelo->setAttributes(array('nick'=>$_POST['Usuarios']['nuevo_nick']));
				//$modelo->setAttributes(array('pass'=>$_POST['Usuarios']['nueva_clave1']));
				$modelo->cambiarClave($_POST['Usuarios']['nueva_clave1']);
				$modelo->setAttributes(array('email'=>$_POST['Usuarios']['nueva_email1']));
				$modelo->setAttributes(array('nivel'=>0));

				if(isset($_POST['pers'])){
					$error = false;
					$selected_radio = $_POST['pers'];
					if ($selected_radio === 'animadora') {
						$animadora_status = true;
						$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_MOVEDORA));

					}else if ($selected_radio === 'empresario') {
						$empresario_status = true;
						$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_EMPRESARIO));

					}else if($selected_radio === 'ultra'){
						$ultra_status = true;
						$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_ULTRA));
					}

					$modelo->setAttributes(array('equipos_id_equipo'=>$_POST['ocup']));
					if ($_POST['ocup']!=0 && $modelo->save()){
						$this->crearRecursos($modelo->id_usuario, $modelo->personaje);
						$transaction->commit();
						$this->redirect(array('site/login'));
					} else $error = true;
				}else $error = true;
			}
		}catch(Exception $e){
			$transaction->rollback();
		}

		$this->render('index',array('modelo'=>$modelo , 'equipos'=>$equipos , 
			'animadora_status'=>$animadora_status , 
			'empresario_status'=>$empresario_status , 
			'ultra_status'=>$ultra_status , 'error'=>$error, 'seleccionado'=>$seleccionado ) );
	}
	
	public function crearRecursos($id_usuario, $personaje){
		$rec=new Recursos;
		$rec->setAttributes(array('usuarios_id_usuario'=>$id_usuario));
		switch ($personaje) {
			case Usuarios::PERSONAJE_MOVEDORA: //animadora
				echo "animadora";
				$rec->setAttributes(array('dinero'=>0));
				$rec->setAttributes(array('dinero_gen'=>0.0));
				$rec->setAttributes(array('influencias'=>0));
				$rec->setAttributes(array('influencias_max'=>0));
				$rec->setAttributes(array('influencias_gen'=>0.0));
				$rec->setAttributes(array('animo'=>0));
				$rec->setAttributes(array('animo_max'=>0));
				$rec->setAttributes(array('animo_gen'=>0.0));
				break;
			case Usuarios::PERSONAJE_EMPRESARIO: //empresario
				echo "empresario";
				$rec->setAttributes(array('dinero'=>0));
				$rec->setAttributes(array('dinero_gen'=>0.0));
				$rec->setAttributes(array('influencias'=>0));
				$rec->setAttributes(array('influencias_max'=>0));
				$rec->setAttributes(array('influencias_gen'=>0.0));
				$rec->setAttributes(array('animo'=>0));
				$rec->setAttributes(array('animo_max'=>0));
				$rec->setAttributes(array('animo_gen'=>0.0));
				break;
			case Usuarios::PERSONAJE_ULTRA: //ultra
				echo "ultra";
				$rec->setAttributes(array('dinero'=>0));
				$rec->setAttributes(array('dinero_gen'=>0.0));
				$rec->setAttributes(array('influencias'=>0));
				$rec->setAttributes(array('influencias_max'=>0));
				$rec->setAttributes(array('influencias_gen'=>0.0));
				$rec->setAttributes(array('animo'=>0));
				$rec->setAttributes(array('animo_max'=>0));
				$rec->setAttributes(array('animo_gen'=>0.0));
				break;
			
			default:
				# code...
				break;
		}
		$rec->save();
	}

	/**
	 * @return array de filtros para actions
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

	/**
	 * Especifica las reglas de control de acceso.
	 * Esta función es usada por el filtro "accessControl".
	 * @return array con las reglas de control de acceso
	 */
	/*public function accessRules()
	{
		return array(
			array('allow', // Permite realizar a los usuarios autenticados cualquier acción
				'users'=>array(''),
			),
			array('deny',  // Niega acceso al resto de usuarios
				'users'=>array('*'),
			),
		);
	}*/
}