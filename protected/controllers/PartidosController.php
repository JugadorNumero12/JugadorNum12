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
	 * Muestra los partidos de la jornada que se esta jugando
	 *
	 * @ruta 	jugadorNum12/partidos
	 */
	public function actionIndex()
	{
		/* ARTURO */
		//Obtener el equipo del usuario
		$id_usuario = Yii::app()->user->usIdent;        
        $equipo_usuario = Usuarios::model()->findByPk($id_usuario)->equipos_id_equipo;

		//TODO Obtener fecha actual (min)
		//TODO Sumarle la duracion de la jornada (max)
		$min = 130;
		$max = 230;

		//Obtener el modelo de Partidos
		//deben cumplir la condicion (hora > min AND hora < max)
		$modeloPartidos = Partidos::model()->findAll('hora >:horaMin AND 
													  hora <:horaMax',
													array(':horaMin'=>$min,
														  ':horaMax'=>$max));

		//Por cada partido obtener los equipos locales y visitantes
		//y averiguar si el equipo del usuario juega en dicho partido
		$esPartidoUsuario = array();
		$equiposLocal = array();
		$equiposVisit = array();
		
		foreach ($modeloPartidos as $partido){
			$id_equipo1 = $partido['equipos_id_equipo_1'];
			$id_equipo2 = $partido['equipos_id_equipo_2'];
			$esPartidoUsuario[] = $id_equipo1 == $equipo_usuario || $id_equipo2 == $equipo_usuario; 
			$equiposLocal[] = Equipos::model()->findByPk($id_equipo1);
			$equiposVisit[] = Equipos::model()->findByPk($id_equipo2);
		}

		//pasar los datos de cada partido a la vista index
		$this->render('index',array('esDeUsuario'=>$esPartidoUsuario,
									'equiposL'=>$equiposLocal,
									'equiposV'=>$equiposVisit
									));
	}

	/** 
	 * Muestra la informacion previa a un partido
	 * 	fecha y hora	
	 *  ambiente para el partido
	 * 	equipo local y visitante
	 * 	detalles de ambos equipos (aforo previsto, nivel de los equipos)
	 *  acciones completadas por las aficiones
	 *
	 * @parametro 	id del partido sobre el que se consulta la previa
	 * @ruta 		jugadorNum12/partidos/previa/{$id_partido}
	 */
	public function actionPrevia($id_partido)
	{
		/* MARINA */
		//Saco la informacion del partido
		$modeloPartidos = Partidos:: model()->findByPk($id_partido);

		//Saco la información de los equipos para mostrar el nombre en la vista
		$modeloEquipoLocal = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_1);
		$modeloEquipoVisitante = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_2);

		//Saco la información de las acciones grupales previstas para el partido por el equipo local
		$modeloGrupalesLocal = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_1));

		//Saco la información de las acciones grupales previstas para el partido por el equipo visitante
		$modeloGrupalesVisitante = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_2));

		$this->render('previa',array('modeloP'=>$modeloPartidos,
									 'modeloL'=>$modeloEquipoLocal,
									 'modeloV'=>$modeloEquipoVisitante,
									 'modeloGL'=>$modeloGrupalesLocal,
									 'modeloGV'=>$modeloGrupalesVisitante));
	}

	/**
	 * Muestra la pantalla para "jugar" un partido
	 * Si el partido ya se jugo, mostrar la cronica (resultado) de ese partido
	 * Si el partido no se ha jugado, y es el proximo partido del
	 * equipo del jugador, mostrar la pantalla de juego de partido
	 * 
	 * @parametro 	$id_partido sobre el que se pide informacion
	 * @ruta 		jugadorNum12/partidos/asistir/{$id_partido}
	 */
	public function actionAsistir($id_partido)
	{
		/* ARTURO */
		// Nota: dejar en blanco (o con un simple mensaje indicativo) 
		// la pantalla de jugar partido

		//Obtener el equipo del usuario
		$id_usuario = Yii::app()->user->usIdent;        
        $id_equipo  = Usuarios::model()->findByPk($id_usuario)->equipos_id_equipo;

		//TODO Obtener hora actual
		$hora_actual = 130;

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
		
		if($hora_actual > $modeloPartido->hora)
		{
			//si el partido se jugo, obtener cronica
			$cronica_partido = $modeloPartido->cronica;			
		}
		elseif($modeloPartido->id_partido == $modeloSigPartido->id_partido)
		{
			//si el partido no se ha jugado y es el siguiente partido del equipo del usuario
			//TODO redirigir a Jugar Partido
			$cronica_partido = 'Jugar Partido';
		}
		else
		{
			//TODO enviar un error y redirigir,
			//no se puede asistir a un partido que esta despues del siguiente partido
			$cronica_partido = 'No hay informacion acerca del partido';
		} 

		//pasar los datos de cada partido a la vista index
		$this->render('asistir', array(	'equipoL'=>$modeloEquipoLocal,
										'equipoV'=>$modeloEquipoVisitante,
									   	'cronica'=>$cronica_partido,
									   	'sigPartido'=>$modeloSigPartido
									  ));
			
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
