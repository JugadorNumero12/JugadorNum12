<?php

/* Esta api permite llamar y testear los diferentes scripts. */
class ScriptsController extends Controller
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
			array('allow', // Permite realizar a todos los usuarios
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Selecciona los partidos en juego y ejecuta sus turnos correspondientes.
	 *
	 * @ruta jugadorNum12/scriptsApi/jugarPartido
	 */
	public function actionEjecutarTurno()
	{
		Yii::import('application.components.Partido');

		$tiempo=time();
		$primerTurno=Partido::PRIMER_TURNO;
		$ultimoTurno=Partido::ULTIMO_TURNO;
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= hora');
		$busqueda->addCondition('turno >= :bPrimerTurno');
		$busqueda->addCondition('turno <= :bUltimoTurno');
		$busqueda->params = array(':bTiempo' => $tiempo,
								'bPrimerTurno' => $primerTurno,
								'bUltimoTurno' => $ultimoTurno);
		$partidos=Partidos::model()->findAll($busqueda);

		foreach ($partidos as $partido)
		{
        	$transaction = Yii::app()->db->beginTransaction();
        	try
        	{
				$partido = new Partido($partido->id_partido);
				$partido->jugarse();   
				$transaction->commit();     		
        	}
        	catch (Exception $ex)
        	{
        		$transaction->rollback();
        		throw $ex;
        	}
		}
	}

	/*
	*
	* Selecciona las acciones individuales pendientes de devolución
	* de recursos (finalización) y ejecuta el método oportuno de cada 
	* una de ellas.
	*
	*/
	public function actionFinalizaIndividuales()
	{
		Yii::import('application.components.Acciones.*');

		$tiempo = time();
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= cooldown');
		$busqueda->addCondition('devuelto = :bDevuelto');
		$busqueda->params = array(':bTiempo' => $tiempo,
								'bDevuelto' => 0,
								);
		$individuales = AccionesIndividuales::model()->findAll($busqueda);

		//Iterar sobre cada individual y finalizarla
		foreach ($individuales as $ind)
		{
			$transaction = Yii::app()->db->beginTransaction();
        	try
        	{
        		//Tomar nombre de habilidad para instanciación dinámica
        		$hab = Habilidades::model()->findByPk($ind->habilidades_id_habilidad);
        		if ($hab === null)
        		{
        			throw new CHttpException(404,"Error: habilidad no encontrada. (actionFinalizaIndividuales,ScriptsController)");
        			
        		}        		
        		$nombreHabilidad =  $hab->codigo;

        		//Llamar al singleton correspondiente y finalizar dicha acción
        		$nombreHabilidad::getInstance()->finalizar($ind->usuarios_id_usuario,$ind->habilidades_id_habilidad);

        		//Actualizar la base de datos para permitir un nuevo uso de la acción
        		$ind->devuelto = 1;

        		if (!$ind->save())
        		{
        			throw new CHttpException(404,"Error: no se ha podido guardar el modelo de acciones individuales. (actionFinalizaIndividuales,ScriptsController)");
        			
        		}

				//Finalizar correctamente la transacción  
				$transaction->commit();     		
        	}
        	catch (Exception $ex)
        	{
        		//Rollback de la transacción en caso de error
        		$transaction->rollback();
        		throw $ex;
        	}
		}
	}

	/*
	*
	* Selecciona las acciones grupales finalizadas sin éxito y devuelve los recursos a sus
	* participantes y creador.
	*
	*/
	public function actionFinalizaGrupales()
	{
		//Traer acciones y Helper	
		Yii::import('application.components.Acciones.*');
		Yii::import('application.components.Helper');

		$helper = new Helper();

		$tiempo = time();
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= finalizacion');
		$busqueda->addCondition('completada = :bCompletada');
		$busqueda->params = array(':bTiempo' => $tiempo,
								'bCompletada' => 0,
								);
		$grupales = AccionesGrupales::model()->findAll($busqueda);

		//Iterar sobre las acciones grupales resultantes de la búsqueda
		foreach ($grupales as $gp)
		{
			$transaction = Yii::app()->db->beginTransaction();
        	try
        	{
				//Tomar participaciones
				$participantes = Participaciones::model()->findAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $gp->id_accion_grupal));
				//Recorro todos los participantes devolviendoles sus recursos.
				//Esto incluye el creador de la acción.
				foreach ($participantes as $participante)
				{
					//Cojo el dinero,influencia y animo aportado por el usuario
					$dinero=$participante->dinero_aportado;
					$influencia=$participante->influencias_aportadas;
					$animo=$participante->animo_aportado;

					//Utilizo el helper para ingresarle al usuario los recursos
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'dinero',$dinero);
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'animo',$animo);
					$helper->aumentar_recursos($participante->usuarios_id_usuario,'influencias',$influencia);

					//Eliminar ese modelo
					Participaciones::model()->deleteAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $gp->id_accion_grupal,'usuarios_id_usuario'=> $participante->usuarios_id_usuario));
				}

				//Borro esa accion grupal iniciada por el usuario que quiere cambiar de equipo
				AccionesGrupales::model()->deleteByPk($gp->id_accion_grupal);

				//Finalizar transacción con éxito
				$transaction->commit();     		
        	}
        	catch (Exception $ex)
        	{
        		//Rollback de la transacción en caso de error
        		$transaction->rollback();
        		throw $ex;
        	}
		}
	}

	/**
	 * Simulador de la fórmula
	 */
	public function actionFormula($dn=0, $am=0, $al=0, $av=0, $ml=0, $mv=0, $ol=0, $ov=0, $dl=0, $dv=0)
	{
		// Creamos el array de parámetros a partir de los datos GET
		$params = array(
 			'difNiv'    => (double) $dn, 'aforoMax'  => (double) $am,
 			'aforoLoc'  => (double) $al, 'aforoVis'  => (double) $av,
			'moralLoc'  => (double) $ml, 'moralVis'  => (double) $mv,
			'ofensLoc'  => (double) $ol, 'ofensVis'  => (double) $ov,
			'defensLoc' => (double) $dl, 'defensVis' => (double) $dv,
		);

		// Obtenemos los pesos y las probabilidades de todos los estados
		for ($i = -10; $i <= 9; $i++) {
			$params['estado'] = ($i == -10) ? null : $i;

			$pesos[$params['estado']] = Formula::pesos($params);
			$probs[$params['estado']] = Formula::probabilidades($params);
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

		// Simulamos un partido con todos los estados iniciales
		for ( $i = -9; $i <= 9; $i++ ) {
			$estados[$i] = array($i);
			$params['estado'] = $i;

			for ( $t = 0; $t < 12; $t++ ) {
				$estSig = Formula::siguienteEstado($params);

				$params['estado'] = $estSig;
				$estados[$i][] = $estSig;
			}
		}

		foreach ($estados as $i=>$v) {
			foreach ($v as $ii=>$vv) {
				if ( $vv < 0 ) {
					$nc = (int)( 255 * (1 + $vv/10) );
					$c = "rgb(255,$nc,$nc)";
				} else if ( $vv > 0) {
					$nc = (int)( 255 * (1 - $vv/10) );
					$c = "rgb($nc,$nc,255)";
				} else {
					$c = 'white';
				}
				$estColors[$i][$ii] = ($c);
			}
		}

		// Dibujamos la vista
		unset($params['estado']);
		
		$this->layout = "main";
		$this->render('formula', array(
			'probs'=>$probs,
			'pesos'=>$pesos,
			'colors'=>$colors,
			'params'=>$params,
			'estados'=>$estados,
			'estColors'=>$estColors
		));
	}

	public function actionPass ()
	{
		$bcrypt = new Bcrypt(12);

		$passes = array(
			'xaby', 'marina', 'arturo', 'dani', 'pedro',
			'manu', 'rober', 'marcos', 'alex', 'samu'
		);

		$result = array();
		foreach ( $passes as $pass ) {
			$hash = $bcrypt->hash($pass);
			$check = $bcrypt->verify($pass,  $hash);

			echo '<pre>';
			print_r(array('pass'=>$pass, 'hash'=>$hash, 'check'=>$check));
			echo '</pre>';
		}


	}
}
