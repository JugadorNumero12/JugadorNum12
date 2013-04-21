<?php

/**
 * Controlador del registro  
 *
 *
 * @package controladores
 */
class RegistroController extends Controller
{
    /** @type String */
    public $layout='//layouts/login';

    /**
     * Muestra el formulario inicial para registrarse en la pagina
     *
     * Registro - Paso 1
     *
     * - nick 
     * - mail
     * - contraseña
     * 
     * > Si hay datos en $_POST procesa el formulario y almacena el nuevo usuario en la tabla <usuarios>
     *
     * @route  jugadorNum12/registro
     * @redirect jugadorNum12/registro/equipo si se completa con exito la primera fase del registro
     *
     * @throws \Exception Fallo al guardar el usuario en la BD
     * @return void
     */
	public function actionIndex()
	{
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
		$this->performAjaxValidation($modelo);

		$transaction = Yii::app()->db->beginTransaction();
		try{
			if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			if (isset($_POST['Usuarios']) ) {
				//$seleccionado = $_POST['ocup'];
				$modelo->attributes=$_POST['Usuarios'];
				//modifico modelo con los datos del formulario
				$modelo->setAttributes(array('nick'=>$_POST['Usuarios']['nuevo_nick']));
				$modelo->cambiarClave($_POST['Usuarios']['nueva_clave1']);
				$modelo->setAttributes(array('email'=>$_POST['Usuarios']['nueva_email1']));

				if($modelo->save()){
					$transaction->commit();
					$this->redirect(array('registro/equipo','id_usuario'=>$modelo->id_usuario));
				}
				else $error = true;
			} 
			else $error = true;
		}catch(Exception $e){
			$transaction->rollback();
			$error = true;
		}

		$this->render('index',array('modelo'=>$modelo , 'equipos'=>$equipos , 
			'animadora_status'=>$animadora_status , 
			'empresario_status'=>$empresario_status , 
			'ultra_status'=>$ultra_status , 'error'=>$error, 'seleccionado'=>$seleccionado ) );
	}

    /** 
     * Muestra el segundo formulario para registrarse en la pagina
     *
     * Registro - Paso 2
     * 
     * - Eleccion del equipo
     *
     * > Si hay datos en $_POST procesa el formulario y almacena el nuevo usuario en la tabla <usuarios>
     *
     * @param int $id_usuario id del usuario que esta completando el registro
     *
     * @route    jugadorNum12/registro/equipo/{$id_usuario}
     * @redirect jugadorNum12/registro/personaje/{$id_usuario}
     *
     * @throws \Exception Fallo al actualizar el usuario en la BD
     * @return void
     */
	public function actionEquipo($id_usuario)
	{
		$modelo = Usuarios::model()->findByPk($id_usuario);
		$modelo->scenario='update';
		$error = false;

		$equip = Equipos::model()->findAll();
		foreach ($equip as $equipo){
			$equipos[$equipo['id_equipo']] = $equipo['nombre'];
		}
		$seleccionado=0;

		$transaction = Yii::app()->db->beginTransaction();	
		try {
			if(isset($_POST['ocup'])) {
				$seleccionado = $_POST['ocup'];
				$modelo->setAttributes(array('equipos_id_equipo'=>$seleccionado));
				if($modelo->save()) {
					$transaction->commit();
					$this->redirect(array('registro/personaje','id_usuario'=>$modelo->id_usuario));
				} else {
					$error = true;
				}
			} else {
				$error = true;
			}
		} catch (Exception $e) {
			$transaction->rollback();
		}
			
		$this->render('equipo',array('error'=>$error,'equipos'=>$equipos, 'seleccionado'=>$seleccionado));
	}
	
    /** 
     * Muestra el tercer formulario para registrarse en la pagina
     *
     * Registro - Paso 3
     * 
     * - Eleccion del personaje
     *
     * > Si hay datos en $_POST procesa el formulario y almacena el nuevo usuario en la tabla <usuarios>
     *
     * @param int $id_usuario id del usuario que esta completando el registro
     *
     * @route    jugadorNum12/registro/personaje/{$id_usuario}
     * @redirect jugadorNum12/index
     *
     * @throws \Exception Fallo al actualizar el usuario en la BD
     * @return void
     */
	public function actionPersonaje($id_usuario)
	{
		$modelo = Usuarios::model()->findByPk($id_usuario);
		$modelo->scenario='update';
		$error = false;

		$animadora_status=false;
		$empresario_status=false;
		$ultra_status=false;

		$transaction = Yii::app()->db->beginTransaction();
		try {
			if(isset($_POST['pers'])){
				$selected_radio = $_POST['pers'];
				if ($selected_radio === 'animadora') {
					$animadora_status = true;
					$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_MOVEDORA));
				} else if ($selected_radio === 'empresario') {
					$empresario_status = true;
					$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_EMPRESARIO));
				} else if($selected_radio === 'ultra'){
					$ultra_status = true;
					$modelo->setAttributes(array('personaje'=>Usuarios::PERSONAJE_ULTRA));
				}

				$modelo->crearPersonaje();
				if($modelo->save()){
					//Usuarios::model()->crearPersonaje($modelo->id_usuario, $modelo->personaje);
					$transaction->commit();
					$this->redirect(array('site/index'));
				} else {
                    $error = true;
                }
			} else {
                $error = true;
            }
		} catch (Exception $e) {
			$transaction->rollback();
		}

		$this->render('personaje',array(
            'error'=>$error,'animadora_status'=>$animadora_status , 
			'empresario_status'=>$empresario_status , 
			'ultra_status'=>$ultra_status)
        );
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	
}
