<?php

/** 
 * Controlador de las jornadas y previas a los partidos 
 *
 *
 * @package controladores
 */
class PartidosController extends Controller
{
    /**
     * Establecer como fondo de la pagina "bg-estadio-dentro"
     *
     * > Llamada a la funcion ```beforeAction```
     *
     * @param object $action
     * @return true
     */
	public function beforeAction ($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}

		Yii::app()->setParams(array('bgclass'=>'bg-estadio-dentro'));

		return true;
	}

   /**
    * Definicion del verbo DELETE unicamente via POST
    *
    * > Funcion predeterminada de Yii
    *
    * @return string[]     filtros definidos para "actions"
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
	 * Muestra dl calendario de la liga.
     *
     * Resalta los partidos del usuario y en especial el próximo partido del usuario
	 *
	 * @route jugadorNum12/partidos
     * @return void
	 */
	public function actionIndex()
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		// Obtener el id del proximo partido del usuario
		Yii::import('application.components.Partido');		
		$id_equipo_usuario = Yii::app()->user->usAfic;
		$equipoUsuario = Equipos::model()->findByPk($id_equipo_usuario);
		$proximoPartido = $equipoUsuario->sigPartido;
		$primer_turno=Partido::PRIMER_TURNO;
		$ultimo_turno=Partido::ULTIMO_TURNO;
		// Obtener la lista de partidos
		$listaPartidos = Partidos::partidosAgrupados();

		//pasar los datos a la vista y renderizarla
		$datosVista = array( 'lista_partidos'=>$listaPartidos, 'equipo_usuario'=>$id_equipo_usuario, 
			'proximo_partido'=>$proximoPartido,'primer_turno'=>$primer_turno,'ultimo_turno'=>$ultimo_turno);
		$this->render('index', $datosVista);
	}

	/** 
	 * Muestra la informacion previa a un partido.
	 * 
	 * 1 Si el partido ya se jugo, mostrar la cronica (resultado) de ese partido
	 * 2 Si el partido no se ha jugado aún y no es el partido próximo mostrar:
	 *     - fecha y hora
     *     - equipos que jugarán
	 * 3 Si el partido es el próximo partido del equipo, mostrar:
	 *     - fecha y hora	
	 *     - ambiente para el partido
	 *     - equipo local y visitante
	 * 	   - detalles de ambos equipos (aforo previsto, nivel de los equipos)
	 *     - acciones completadas por las aficiones
	 *
	 * @param int $id_partido  id del partido sobre el que se consulta la previa
     *
	 * @route 		jugadorNum12/partidos/previa/{$id_partido}
     * @redirect    jugadorNum12/partidos/index     si se intenta asistir a un partido posterior al siguiente
     * 
     * @return void
	 */
	public function actionPrevia($id_partido)
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */
		
		//Saco la informacion del partido
		$modeloPartidos = Partidos:: model()->findByPk($id_partido);

		//Saco la información de los equipos para mostrar el nombre en la vista
		$modeloEquipoLocal = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_1);
		$modeloEquipoVisitante = Equipos:: model()->findByPk($modeloPartidos->equipos_id_equipo_2);

		//Saco la información de las acciones grupales previstas para el partido por el equipo local
		$modeloGrupalesLocal = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_1));
	
		//Saco la información de las acciones grupales previstas para el partido por el equipo visitante
		$modeloGrupalesVisitante = AccionesGrupales:: model()->findAllByAttributes(array('equipos_id_equipo'=>$modeloPartidos->equipos_id_equipo_2));

		
		//Obtener hora actual,de momento 130 porque no estan ajustadas las horas en la tabla
		$hora_actual = 130;

		//Obtener el equipo del usuario
		$id_usuario = Yii::app()->user->usIdent;        
        $id_equipo  = Usuarios::model()->findByPk($id_usuario)->equipos_id_equipo;

		//Obtener el partido a consultar y
		//el siguiente partido del equipo del usuario
		$modeloPartido    = Partidos::model()->findByPk($id_partido);
		$modeloSigPartido = Equipos::model()->findByPk(Yii::app()->user->usAfic)->sigPartido;

		//Si el partido se encuentra en su ultimo turno muestro la cronica
		///Sino muestro la previa del partido, si es el siguiente que juega el equipo
		//Sino cumple ninguna de esas condiciones muestro que no tengo informacion

		Yii::import('application.components.Partido');
		$ultimo_turno=Partido::ULTIMO_TURNO;
	
		if($modeloPartido->turno == $ultimo_turno+1) 
		{
			// Cargar css de previa
			//$uri = Yii::app()->request->baseUrl.'/less/infopartido.less';
			//Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);
			
			//si el partido se jugo, obtener cronica
			$this->render('cronica',array(	'modeloP'=>$modeloPartidos,
									 		'modeloL'=>$modeloEquipoLocal,
									 		'modeloV'=>$modeloEquipoVisitante
									 		)); 	
		} elseif($id_partido == $modeloSigPartido->id_partido && $modeloSigPartido->turno == 0) 
		{
			// Cargar css de previa
			//$uri = Yii::app()->request->baseUrl.'/less/infopartido.less';
			//Yii::app()->clientScript->registerLinkTag('stylesheet/less', 'text/css', $uri);

			//si el partido no se ha jugado y es el siguiente partido del equipo del usuario
			//Renderizo la vista que me muestra la previa
			$this->render('previa',array('modeloP'=>$modeloPartidos,
									 'modeloL'=>$modeloEquipoLocal,
									 'modeloV'=>$modeloEquipoVisitante,
									 'modeloGL'=>$modeloGrupalesLocal,
									 'modeloGV'=>$modeloGrupalesVisitante
									 )); 	
		} else {
			//no se puede asistir a un partido que esta despues del siguiente partido
			Yii::app()->user->setFlash('Partido', 'No hay informacion acerca del partido');
			$this-> redirect(array('partidos/index'));
		}
	}

    /**
     * Muestra la pantalla para jugar un partido
     *
     * Comprobaciones realizadas:
     *
     * - acceso correcto al partido, equipos en la BD
     * - el partido esta jugandose (turnos €[1, 11])
     * - un usuario solo puede asistir al proximo partido de un equipo
     *
     * @param int $id_partido   id del partido al que se va a asistir
     * 
     * @route jugadorNum12/partidos/asistir/{$id_partido}
     * @return void
     */
	public function actionAsistir($id_partido)
	{
		/* Actualizar datos de usuario (recuros,individuales y grupales) */
		Usuarios::model()->actualizaDatos(Yii::app()->user->usIdent);
		/* Fin de actualización */

		Yii::import('application.components.Partido');
		
		// Obtener el equipo del usuario
		$id_equipo_usuario = Yii::app()->user->usAfic;
		$equipoUsuario = Equipos::model()->findByPk($id_equipo_usuario);

		// Obtener la informacion del partido, 
		// En $partido participan $equipo_local y $equipo_visitante
		$partido = Partidos::model()->findByPk($id_partido);
		$equipoLocal = Equipos::model()->findByPk($partido->equipos_id_equipo_1);
		$equipoVisitante = Equipos::model()->findByPk($partido->equipos_id_equipo_2);

		//Comprobacion de datos
		if (($partido === null) || ($equipoUsuario === null) || ($equipoLocal === null) || ($equipoVisitante === null)) {
			Yii::app()->user->setFlash('datos', 'Datos suministrados incorrectos - partido/equipo/local/visitante -. (actionActPartido).');
			$this-> redirect(array('partidos/index'));
		}
		if ($partido->turno <= Partido::PRIMER_TURNO ||  $partido->turno > Partido::ULTIMO_TURNO) {
			Yii::app()->user->setFlash('partido', 'El partido no está en juego.');
			$this-> redirect(array('partidos/index'));
		}

		// Un usuario no puede asisitir a un partido en el que su equipo no participa
        // TODO eliminar esta restriccion
		if (($partido->equipos_id_equipo_1 != $id_equipo_usuario) && ($partido->equipos_id_equipo_2 != $id_equipo_usuario))  {		
			Yii::app()->user->setFlash('partido', 'No puedes acceder a un partido en el que no participe tu equipo.');							
			$this-> redirect(array('partidos/index'));
		} else {
            // Un usuario solo puede asistir al próximo partido de su equipo
			if($equipoUsuario->partidos_id_partido != $id_partido ) {			
				Yii::app()->user->setFlash('partido', 'Este no es el próximo partido de tu equipo.');
				$this-> redirect(array('partidos/index'));
			} 
			else 
			{
		        //Saca la lista de las acciones desbloqueadas por el usuario
		        $modeloDesbloqueadas = Desbloqueadas:: model()->findAllByAttributes(array('usuarios_id_usuario'=>Yii::app()->user->usIdent));
				//Prepara los datos de las acciones de partido
		        $accionesPar = array();
		        $desblPar = array();
		        foreach ($modeloDesbloqueadas as $desbloqueada)
		        {
		            $infoDesbloqueada = Habilidades::model()->findAllByAttributes(array('id_habilidad' => $desbloqueada->habilidades_id_habilidad));
		            if ($infoDesbloqueada[0]['tipo'] == Habilidades::TIPO_PARTIDO ) 
		            {
		                $accionesPar[] = $infoDesbloqueada[0];
		                $desblPar[] = $desbloqueada;
		            }
		        }
            	//pasar los datos del partido y los equipos
                $datosVista = array(
                    'eqLoc' => $equipoLocal,
                    'eqVis' => $equipoVisitante,
                    'partido' => $partido,
                    'l_acciones' => $accionesPar,
                    'l_desbl' => $desblPar
                );
                $this->render('asistir', $datosVista);

            /* PARTE DE MASTER
                // un usuario no puede asisitir a un partido en el que su equipo no participa
                if ( ($equipoLocal->id_equipo != $id_equipo_usuario) && ($equipoVisitante->id_equipo != $id_equipo_usuario) ) {

                    // TODO
                    Yii::app()->user->setFlash('propio_equipo', 'No puedes asistir a un partido que no sea de tu propio equipo.');
                    $this-> redirect(array('partidos/index'));

                } 
                // un usuario solo puede asistir al próximo partido de su equipo
                else if( $equipoUsuario->partidos_id_partido != $partido->id_partido ) {

                    // TODO 
                    Yii::app()->user->setFlash('sig_partido', 'Ese no es el proximo partido de tu equipo.');
                    $this-> redirect(array('partidos/index'));
                }
            */
			}
		}
	}

	/**
	 *
	 * renderiza el estado completo de un partido
     *
     * - marcador
	 * - tiempo
     * - crónica
	 *
     * @param int $id_partido id del partido 
     * 
     * @route jugadorNum12/partidos/actPartido/{$id_partido}
     * @return void
	 */
	public function actionActPartido($id_partido)
	{	
        // FIXME: ¿misma logica que actionAsistir?

		// Obtener el equipo del usuario
		$equipoUsuario = Equipos::model()->findByPk(Yii::app()->user->usAfic);

		// Obtener la informacion restante necesaria
		$partido = Partidos::model()->findByPk($id_partido);
		$equipoLocal = Equipos::model()->findByPk($partido->equipos_id_equipo_1);
		$equipoVisitante = Equipos::model()->findByPk($partido->equipos_id_equipo_2);

		//Comprobación de datos
		if (($partido === null) || ($equipoUsuario === null) || ($equipoLocal === null) || ($equipoVisitante === null)) {
			Yii::app()->user->setFlash('datos', 'Datos suministrados incorrectos - partido/equipo/local/visitante -. (actionActPartido).');	
		}

		// Un usuario no puede asisitir a un partido en el que su equipo no participa
		if (($partido->equipos_id_equipo_1 != $equipoUsuario->id_equipo) && ($partido->equipos_id_equipo_2 != $equipoUsuario->id_equipo)) {			
			Yii::app()->user->setFlash('partido', 'No puedes acceder a un partido en el que no participe tu equipo. (actionActPartido).');
			//throw new Exception("No puedes acceder a un partido en el que no participe tu equipo. (actionActPartido)", 401);							
		} else if ($equipoUsuario->partidos_id_partido != $id_partido ) {			
			Yii::app()->user->setFlash('partido', 'Este no es el próximo partido de tu equipo. (actionActPartido).');
			//throw new Exception("Este no es el próximo partido de tu equipo. (actionActPartido)", 401);				
		} else {
			//pasar los datos del partido y los equipos
			$data = array(
				'golesLocal' => (int) $partido->goles_local,
				'golesVisit' => (int) $partido->goles_visitante,
				'turno' => (int) $partido->turno,
				'estado' => (int) $partido->estado,
				'tiempo' => (int) $partido->tiempoRestantePartido(),
				'tiempoTurno' => (int) $partido->tiempoRestanteTurno(),
				// Agregados para la cronica y estado del partido
				'cronica' => (string) $partido->cronica,
				'ambiente' => (int) $partido->ambiente,
				'nivel_local' => (int) $partido->nivel_local,
				'nivel_visitante' => (int) $partido->nivel_visitante,
				'ofensivo_local' => (int) $partido->ofensivo_local,
				'ofensivo_visitante' => (int) $partido->ofensivo_visitante,
				'defensivo_local' => (int) $partido->defensivo_local,
				'defensivo_visitante' => (int) $partido->defensivo_visitante,		
				'aforo_local' => (int) $partido->aforo_local,
				'aforo_visitante' => (int) $partido->aforo_visitante,
				'moral_local' => (int) $partido->moral_local,
				'moral_visitante' => (int) $partido->moral_visitante,
				//'estado' => $partido
			);

			echo CJavaScript::jsonEncode($data);
			Yii::app()->end();
		}
	}

	/**
	 *
	 * Incrementa los recursos durante el partido de forma asíncrona
     *
     * @param int $id_usuario id del usuario al que incrementar recursos
     * 
     * @route jugadorNum12/partidos/actRecursos/{$id_usuario}
     * @return JSON con los datos necesarios para llevar a cabo la actualización
	 */
	public function actionActRecursos($id_usuario)
	{
        Recursos::model()->actualizaRecursos($id_usuario);
        $datos = Recursos::model()->findByPk($id_usuario);
        if ($datos !== null)
        {
        	echo json_encode(array('codigo' => (int)1,
        							'influencias' => (int)$datos->influencias,
									'dinero' => (int)$datos->dinero,
									'animo' => (int)$datos->animo,
        							'influencias_max' => (int)$datos->influencias_max,
        							'animo_max' => (int)$datos->animo_max,
								));
			Yii::app()->end();
        }
        else
        {
        	echo json_encode(array('codigo' => (int)0,
        							'influencias' => (int)0,
									'dinero' => (int)0,
									'animo' => (int)0,
        							'influencias_max' => (int)0,
        							'animo_max' => (int)0,
								));
			Yii::app()->end();
        }
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
		$model=Partidos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='partidos-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
}
