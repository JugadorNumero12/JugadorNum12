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
								':bPrimerTurno' => $primerTurno,
								':bUltimoTurno' => $ultimoTurno);
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
								':bDevuelto' => 0,
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
        			Yii::app()->user->setFlash('habilidad', 'Error: habilidad no encontrada. (actionFinalizaIndividuales,ScriptsController).');
        			//throw new CHttpException(404,"Error: habilidad no encontrada. (actionFinalizaIndividuales,ScriptsController)");
        			
        		}        		
        		$nombreHabilidad =  $hab->codigo;

        		//Llamar al singleton correspondiente y finalizar dicha acción
        		$nombreHabilidad::getInstance()->finalizar($ind->usuarios_id_usuario,$ind->habilidades_id_habilidad);

        		//Actualizar la base de datos para permitir un nuevo uso de la acción
        		$ind->devuelto = 1;

        		if (!$ind->save())
        		{
        			Yii::app()->user->setFlash('guardar', 'Error: no se ha podido guardar el modelo de acciones individuales. (actionFinalizaIndividuales,ScriptsController).');
        			//throw new CHttpException(404,"Error: no se ha podido guardar el modelo de acciones individuales. (actionFinalizaIndividuales,ScriptsController)");
        			
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

		$tiempo = time();
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= finalizacion');
		$busqueda->addCondition('completada = :bCompletada');
		$busqueda->params = array(':bTiempo' => $tiempo,
								':bCompletada' => 0,
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
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'dinero',$dinero);
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'animo',$animo);
					Recursos::aumentar_recursos($participante->usuarios_id_usuario,'influencias',$influencia);

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

	///LIGA
	private function calendario($participantes=null){
		if($participantes===null)
			$participantes=Clasificacion::->select('equipos_id_equipo');
			//esto debería devolver una lista con todos los id_equipo

		const N = count($participantes);
		$calendario = array();

		//https://github.com/samuelmgalan/CalendarioLiga/blob/master/src/src/Calendario.java
		$cont = 0;
		$cont2 = N-2;
		for($i=0; $i<N-1; $i++){
			for($j=0; $j<$N/2; $j++){

				$eq0 = $participantes[$cont++];
				if($cont==(N-1)) $cont=0;

				if($j==0) $eq1 = $participantes[N-1];
				else {
					$eq1 = $participantes[$cont2--];
					if($cont2<0) $cont2 = N-2;
				}

				//Elaboro la matriz final de enfrentamientos por jornada
				if($j==0 && $i%2==0){
						//primera vuelta
						$calendario[$i][$j][0] = $eq1;
						$calendario[$i][$j][1] = $eq0;

						//segunda vuelta
						$calendario[$i+N-1][$j][0] = $eq0;
						$calendario[$i+N-1][$j][1] = $eq1;
				}else {
						//primera vuelta
						$calendario[$i][$j][0] = $eq0;
						$calendario[$i][$j][1] = $eq1;

						//segunda vuelta
						$calendario[$i+N-1][$j][0] = $eq1;
						$calendario[$i+N-1][$j][1] = $eq0;
				}

			}
		}

		return $calendario;
	}

	/*
	* Genera una liga nueva que:
	*  empezará en '$dentro_de' dias, 
	*  dejará '$jornada' dias entre jornadas (si metes null escoje el minimo que no superpone jornadas)
	*  y sus partidos se jugarán a las '$horas' (si hay pocas horas, se juegan el día anterior en el mismo horario).
	*
	* Los partidos se generan "talcual" en el orden en que vienen en '$emparejamientos'
	*/
	public function generaLiga($emparejamientos=null, $dentro_de=1, $jornada=null, $horas=array(22,21,20,19,18,17,16,12))
	{
		if($emparejamientos=== null) $emparejamientos= calendario();
		const un_dia = 3600*24;
		const partidosXdia = count($horas);
		const diasXjornada = ceil( count($emparejamientos[0]) / partidosXdia);

		if($jornada=== null) $jornada= diasXjornada;

		if(diasXjornada<$jornada)
			Yii::log("Las jornadas se superponen unas a otras, aumente la separación entre ellas",'warning');

		$fecha = time(); // hoy, este segundo
		$fecha -= $fecha % un_dia; // las 0:00 de hoy
		$fecha += un_dia*($dentro_de+diasXjornada-1); // las 0:00 del día de la primera jornada.

	    $transaction = Yii::app()->db->beginTransaction();
    	try
    	{
			foreach ($emparejamientos as $jornada) {

				foreach ($jornada as $partido) {
					$h = 0; //escojer la primera hora diponible
					$time = $fecha;//la fecha "origen" de la jornada

					generaPartido($partido[0], $partido[1], $time+$horas[$h]*3600);

					if(++$h >=partidosXdia)//si ya no hay más horas ese día
					{
						$h = 0;
						$time -= un_dia;//empiezo a rellenar el día anterior
					}
				}
				$fecha += un_dia*$jornada;
			}

			$transaction->commit();
    	}
    	catch (Exception $ex)
    	{
    		$transaction->rollback();
    		throw $ex;
    	}

	}

	/*
	* Añade un nuevo partido entre los equipos indicados en la fecha indicada.
	* 
	* No compruebo, que los equipos existan (en principio eso me da igual).
	* 
	* No relleno los datos (nivelEq, indOfens, ...) porque evidentemente puden cambiar hasta que empiece el partido.
	* Habrá que rellenarlos (si son necesarios) en el primer turno de partido.
	*/
	private function generaPartido(int $id_local, int $id_visitande, int $time)
	{
		if($time<time()) 
			throw new Exception("Los viajes en el tiempo no esta implemetados en esta version del juego.");
		$partido = new Partido();
		$partido->setAttributes(array('equipos_id_equipo_1' => $id_local,
		   							  'equipos_id_equipo_2' => $id_visitande,
		   							  'hora' => $time,
		   							));
		$partido->save();
      

	}
}
