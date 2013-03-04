<?php

/* pagina con la informacion de las jornadas y previas a los partidos */
class PartidosController extends Controller
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
	 * Muestra dl calendario de la liga. Resalta los partidos del usuario y
	 * en especial el próximo partido del usuario
	 *
	 * @ruta 	jugadorNum12/partidos
	 */
	public function actionIndex()
	{
		// Obtener el id del proximo partido del usuario
		$id_equipo_usuario = Yii::app()->user->usAfic;
		$equipoUsuario = Equipos::model()->findByPk($id_equipo_usuario);
		$id_proximoPartido = $equipoUsuario->partidos_id_partido;

		// Obtener la lista de partidos
		$listaPartidos = Partidos::model()->findAll();

		//pasar los datos a la vista y renderizarla
		$datosVista = array( 'lista_partidos'=>$listaPartidos, 'equipo_usuario'=>$id_equipo_usuario, 'proximo_partido'=>$id_proximoPartido);
		$this->render('index', $datosVista);
	}

	/** 
	 * Muestra la informacion previa a un partido.
	 * 
	 *  Si el partido ya se jugo, mostrar la cronica (resultado) de ese partido
	 * 	Si el partido no se ha jugado aún y no es el partido próximo mostrar:
	 * 		fecha y hora; equipos que jugarán
	 *  Si el partido es el próximo partido del equipo, mostrar:
	 *  	fecha y hora	
	 *  	ambiente para el partido
	 * 		equipo local y visitante
	 * 		detalles de ambos equipos (aforo previsto, nivel de los equipos)
	 *  	acciones completadas por las aficiones
	 *
	 * @parametro 	id del partido sobre el que se consulta la previa
	 * @ruta 		jugadorNum12/partidos/previa/{$id_partido}
	 */
	public function actionPrevia($id_partido)
	{
		//Saco la informacion del partido
		$modeloPartidos = Partidos:: model()->findByPk($id_partido);

		//Saco la información de los equipos para mostrar el nombre en la vista
		$modeloEquipoLocal = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_1);
		$modeloEquipoVisitante = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_2);

		//Saco la información de las acciones grupales previstas para el partido por el equipo local
		$modeloGrupalesLocal = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_1));
	
		//Saco la información de las acciones grupales previstas para el partido por el equipo visitante
		$modeloGrupalesVisitante = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_2));

		
		//TODO Obtener hora actual
		$hora_actual = 130;

		//Obtener el equipo del usuario
		$id_usuario = Yii::app()->user->usIdent;        
        $id_equipo  = Usuarios::model()->findByPk($id_usuario)->equipos_id_equipo;

		

		//Obtener el partido a consultar y
		//el siguiente partido del equipo del usuario
		$modeloPartido    = Partidos::model()->findByPk($id_partido);
		$modeloSigPartido = Partidos::model()->find('(equipos_id_equipo_1 =:equipo OR 
													  equipos_id_equipo_2 =:equipo) AND 
													  hora >:horaAct',
													array(':equipo'=>$id_equipo,
														  ':horaAct'=>$hora_actual));

		//Saco la información de los equipos para mostrar el nombre en la vista
		$modeloEquipoLocal     = Equipos::model()->findByPk($modeloPartido->equipos_id_equipo_1);
		$modeloEquipoVisitante = Equipos::model()->findByPk($modeloPartido->equipos_id_equipo_2);

		//Declaracion de todas las variables que usa el render
		$pasado=$presente=false;
		$cronica_partido="ESTO ESTÁ MAL";
		if($hora_actual > $modeloPartido->hora)
		{
			//si el partido se jugo, obtener cronica
			$pasado = true;
			$cronica_partido = $modeloPartido->cronica;			
		}
		elseif($id_partido == $modeloSigPartido->id_partido)
		{
			//si el partido no se ha jugado y es el siguiente partido del equipo del usuario
			$presente = true;
			
		}
		else
		{
			//TODO enviar un error y redirigir,
			//no se puede asistir a un partido que esta despues del siguiente partido
			$cronica_partido = 'No hay informacion acerca del partido';
		}

		$this->render('previa',array('modeloP'=>$modeloPartidos,
									 'modeloL'=>$modeloEquipoLocal,
									 'modeloV'=>$modeloEquipoVisitante,
									 'modeloGL'=>$modeloGrupalesLocal,
									 'modeloGV'=>$modeloGrupalesVisitante,
									 'partido_pasado'=>$pasado,
									 'cronica'=>$cronica_partido,
									 'partido_presente'=>$presente)); 
	}

	/**
	 * Muestra la pantalla para "jugar" un partido
	 * 
	 * De momento, solo muestra una pantalla con información básica
	 *
	 * @parametro 	$id_partido sobre el que se pide informacion
	 * @ruta 		jugadorNum12/partidos/asistir/{$id_partido}
	 */
	public function actionAsistir($id_partido)
	{
		// Nota: dejar con un simple mensaje indicativo una pantalla 
		// con un texto similar a "has asistido al partido" 

		// obtener el equipo del usuario
		$id_equipo_usuario = Yii::app()->user->usAfic;
		$equipoUsuario = Equipos::model()->findByPk($id_equipo_usuario);

		// obtener la informacion del partido, 
		// en $partido participan $equipo_local y $equipo_visitante
		$partido 			= Partidos::model()->findByPk($id_partido);
		$equipoLocal     	= Equipos::model()->findByPk($partido->equipos_id_equipo_1);
		$equipoVisitante 	= Equipos::model()->findByPk($partido->equipos_id_equipo_2);

		// un usuario no puede asisitir a un partido en el que su equipo no participa
		if ( ($equipoLocal->id_equipo != $id_equipo_usuario) && ($equipoVisitante->id_equipo != $id_equipo_usuario) ) {
			
			/* TODO */
			Yii::app()->user->setFlash('propio_equipo', 'No puedes asistir a un partido que no sea de tu propio equipo.');
			$this-> redirect(array('partidos/index'));
		
		} 
		// un usuario solo puede asistir al próximo partido de su equipo
		else if( $equipoUsuario->partidos_id_partido != $partido->id_partido ) {
			
			/* TODO */
			Yii::app()->user->setFlash('sig_partido', 'Ese no es el proximo partido de tu equipo.');
			$this-> redirect(array('partidos/index'));

		} 
		// Intentamos asistir a un partido valido
		else {
			
			//pasar los datos del partido y los equipos
			$datosVista = array( 'equipo_local'		=> $equipoLocal,
								 'equipo_visitante'	=> $equipoVisitante,
								 'partido'			=> $partido);
			$this->render('asistir', $datosVista);
		}	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Partidos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='partidos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
