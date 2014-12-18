<?php

/**
* Esta api permite llamar y testear los diferentes scripts.
*
* @package controladores
*/

class ScriptsController extends Controller
{
	/**
     * Definicion del verbo DELETE unicamente via POST
     *
     * > Funcion predeterminada de Yii
     *
     * @return string[] 	filtros definidos para "actions"
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
     *  - Permite realizar a todos los usuarios cualquier accion
     *
     * > Funcion predeterminada de Yii 
     *
     * @return object[] 	reglas usadas por el filtro "accessControl"
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
	 * @route JugadorNum12/scripts/ejecutarturno
	 * @return void
	 */
	public function actionEjecutarTurno()
	{
		self::ejecutarTurno(true);
	}

	public static function ejecutarTurno ($forzar=false)
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

	/**
	 * Devuelve los recursos de las acciones individuales
	 *
	 * Selecciona las acciones individuales pendientes de devolución
	 * de recursos (finalización) y ejecuta el método oportuno de cada
	 * una de ellas.
	 *
	 * @route JugadorNum12/scripts/finalizaIndividuales
	 *
	 * @throws \Exception excepcion interna
	 * @return void
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

	/**
	* Devuelve los recursos de las acciones grupales a los participantes
	*
	* Selecciona las acciones grupales finalizadas sin éxito y devuelve los recursos a sus
	* participantes y creador.
	*
	* @route JugadorNum12/scripts/finalizaGrupales
	*
	* @throws \Exception excepcion interna
	* @return void
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
	 * Simulador de la formula estadistica
	 *
	 * Crea una vista en la que se muestra el simulador de un partido
	 *
	 * @param int $dn   diferencia de nivel
	 * @param int $am   aforo maximo
	 * @param int $al   aforo local
	 * @param int $av   aforo visitante
	 * @param int $ml   moral local
	 * @param int $mv   moral visitinate
	 * @param int $ol   ofensiva local
	 * @param int $ov   ofensiva visitante
	 * @param int $dl   defensa local
	 * @param int $dv   defensa visitante
     *
     * @route JugadorNum12/scripts/formula
     * @return void
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

	/**
	* Crea los emparejamientos para los equipos dados por parametro
	*
	* Dada una lista de id_equipos, genera unos emparejamientos con el codigo se sam.
	* Ej : calendario(array(1,2,6,7,8)); -> emaprejamientos para los equipos_id = 1,2,3,6,7,8 (deja fuera al 4 y 5)
	* Si no se pasan paritcipantes, coje todos los equipos que haya en la tabla Clasificacion.
	*
	* @param int[] $participantes   id de los equipos participantes
	* @return int[][]
	*/
	private static function calendario($participantes=null)
	{
		if($participantes===null){//devolver una lista con todos los id_equipo
    		$i=0;
    		$participantes = array();
    		$consulta=Clasificacion::model()->findAll();
    		foreach ($consulta as $row) 
    			$participantes[$i++]= (int)$row['equipos_id_equipo'];
    	}

		$N = count($participantes);
		$calendario = array();

		//https://github.com/samuelmgalan/CalendarioLiga/blob/master/src/src/Calendario.java
		$cont = 0;
		$cont2 = $N-2;
		for($i=0; $i<$N-1; $i++)
			for($j=0; $j<$N/2; $j++){

				$eq0 = $participantes[$cont++];
				if($cont==($N-1)) $cont=0;

				if($j==0) $eq1 = $participantes[$N-1];
				else {
					$eq1 = $participantes[$cont2--];
					if($cont2<0) $cont2 = $N-2;
				}

				//Elaboro la matriz final de enfrentamientos por jornada
				if($j==0 && $i%2==0){
						//primera vuelta
						$calendario[$i][$j][0] = $eq1;
						$calendario[$i][$j][1] = $eq0;

						//segunda vuelta
						$calendario[$i+$N-1][$j][0] = $eq0;
						$calendario[$i+$N-1][$j][1] = $eq1;
				}else {
						//primera vuelta
						$calendario[$i][$j][0] = $eq0;
						$calendario[$i][$j][1] = $eq1;

						//segunda vuelta
						$calendario[$i+$N-1][$j][0] = $eq1;
						$calendario[$i+$N-1][$j][1] = $eq0;
				}

			}

		return $calendario;
	}

	/**  
	*  Genera una nueva liga
	*
	*  Genera una liga nueva que:
	*  - empezará en '$dentro_de' dias, 
	*  - dejará '$descanso' dias entre jornadas (si metes null escoje el minimo que no superpone jornadas)
	*  - sus partidos se jugarán a las '$horas' (si hay pocas horas, se juegan el día anterior en el mismo horario).
	*
	* > Las horas se introducen como un entero entre 0 y 24, que corresponde con la hora GMT+0
	*	Ej: en verano: array(20, 17.5, 13) => los partidos se jugarán a las 22:00, 19:30, 15:00 (hora española)
	*		en invierno: array(11.25, 9)   => los partidos se jugarán a las 12:15, 10:00 (hora española)
	*
	* Los partidos se generan en el orden definido en '$emparejamientos'.
	* > WARNING todo el algoritmo esta diseñado para tomar como refernecia de cambio de día las 0:00 GMT
	*
	* @param int[][] $emparejamientos   matriz de equipos emparejados generada en la funcion calendario
	* @param int $dentro_de   dias entre partidos
	* @param $descanso   dias de descanso
	* @param int[] $horas    horas a las que se juegan los partidos
	*
	* @throws \Exception excepcion interna
	* @return void
	*/
	public static function generaLiga(
		$emparejamientos=null, $dentro_de=1, $descanso=null,
		$horas=array(20,19,18,17,16,15,16,10), $periodo=86400)
	{
		if($emparejamientos=== null) $emparejamientos= self::calendario();

		$partidosXdia = count($horas);
		$diasXjornada = ceil( count($emparejamientos[0]) / $partidosXdia);

		if($descanso=== null) $descanso= $diasXjornada;

		if($diasXjornada<$descanso)
			Yii::log("Las jornadas se superponen unas a otras, aumente la separación entre ellas",'warning');

		// 86400==segundos de un dia (60²*24)

		$fecha = time(); // hoy, este segundo
		$fecha -= $fecha % 68400; // las 0:00 de hoy
		$fecha += (int)($periodo*($dentro_de+$diasXjornada-1)); // las 0:00 del día de la primera jornada.

	    $transaction = Yii::app()->db->beginTransaction();
    	try
    	{
    		$jornada_act = 1;
			foreach ($emparejamientos as $jornada) {

				$time = $fecha;//time = la fecha "origen" de la jornada
				$h = 0; //escojer la primera hora diponible

				foreach ($jornada as $partido) {
					self::generaPartido($partido[0], $partido[1], (int)($time+ $horas[$h]*$periodo), $jornada_act, false);

					if(++$h >=$partidosXdia)//si ya no hay más horas ese día
					{
						$h = 0;
						$time -= $periodo;//empiezo a rellenar el día anterior
					}
				}

    			$jornada_act++;
				$fecha += $periodo*$descanso;
			}

			$transaction->commit();
    	}
    	catch (Exception $ex)
    	{
    		$transaction->rollback();
    		throw $ex;
    	}

	}

	/**
	* Añade un nuevo partido entre los equipos indicados en la fecha indicada.
	*
	* >ADVERTENCIA:
	* Los datos (dif_niveles, indOfens, ...) puden cambiar hasta que empiece el partido,
	* aqui se rellenan (porque se me ha pedido explicitamente),
	* pero deberían actualizarse en el primer turno de partido.
	*
	* >ATENCION los partidos empiezan con sigpartido -> id = 0 !!!!
	*
	* @param int $id_local   id del equipo local
	* @param int $id_visitande   id del equipo visitante
	* @param int $time   hora del partido
	* @param int $jornada   jornada de la liga
	* @param bool $generateNewTransaction   generar nueva transaccion
	*
	* @throws \Exception excepcion interna
	* @return void
	*/
	public static function generaPartido($id_local, $id_visitande, $time, $jornada=0, $generateNewTransaction=true)
	{
		//if($time<time()) 
		//	throw new Exception("Los viajes en el tiempo no esta implemetados en esta version del juego.");

		if($generateNewTransaction)
			$transaction = Yii::app()->db->beginTransaction();

		$equipo_local = Equipos::model()->findByPk($id_local);
		$equipo_visitante = Equipos::model()->findByPk($id_visitande);

		if($equipo_local===null||$equipo_visitante===null)return;

		try
    	{
			$partido = new Partidos();
			$partido->setAttributes(array('equipos_id_equipo_1' => $id_local,
			   							  'equipos_id_equipo_2' => $id_visitande,
			   							  'hora' => $time,
			   							  'jornada' => $jornada,
			   							  'nivel_local'=>$equipo_local->nivel_equipo,
			   							  'nivel_visitante'=>$equipo_visitante->nivel_equipo,
			   							  'dif_niveles'=>(($equipo_local->nivel_equipo)-($equipo_visitante->nivel_equipo)),
			   							  'aforo_local'=>$equipo_local->aforo_base,
			   							  'aforo_visitante'=>$equipo_visitante->aforo_base,
			   							  'ofensivo_local'=>$equipo_local->factor_ofensivo,
			   							  'ofensivo_visitante'=>$equipo_visitante->factor_ofensivo,
			   							  'defensivo_local'=>$equipo_local->factor_defensivo,
			   							  'defensivo_visitante'=>$equipo_visitante->factor_defensivo,
			   							));
			
			$partido->save();


			if (($equipo_local->partidos_id_partido == 0) || ($time < $equipo_local->sigPartido->hora)){
				$equipo_local->setAttributes(array('partidos_id_partido'=>$partido->id_partido));
				$equipo_local->save();
			}
				
			
			
			if(($equipo_visitante->partidos_id_partido == 0) || ($time < $equipo_visitante->sigPartido->hora)){
				$equipo_visitante->setAttributes(array('partidos_id_partido'=>$partido->id_partido));
				$equipo_visitante->save();
			}
				

			if($generateNewTransaction) $transaction->commit();
    	}
    	catch (Exception $ex)
    	{
    		if($generateNewTransaction) $transaction->rollback();
    		throw $ex;
    	}
      

	}

	/**
	* Genera una liga con emparejamientos por defecto, que empieza mañana, con jornadas cada 2 días
	*
	* @route JugadorNum12/scripts/liga
	* @return void
	*/
	public function actionLiga(){
		self::generaLiga(null, 1, 2, array(19.5, 17, 15.5) );
		//genera una liga con emparejamientos por defecto, que empieza mañana, con jornadas cada 2 días
	}
}
