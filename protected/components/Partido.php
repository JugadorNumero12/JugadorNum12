<?php
/**
*
* CLASE PARA EL PARTIDO
*
*/
public class Partido
{
	/* Un partido se juega entre los turnos 1 - 10 */
	const PRIMER_TURNO = 0;
	const ULTIMO_TURNO = 10;

	private $id_partido;
	private $id_local;
	private $id_visitante;
	private $turno;
	private $cronica;
	private $ambiente;
	private $dif_niveles;
	private $aforo_local;
	private $aforo_visitante;

	private $ofensivo_local;
	private $ofensivo_visitante;
	private $defensivo_local;
	private $defensivo_visitante;
	
	private $goles_local;
	private $goles_visitante;
	private $estado;
	private $moral_local;
	private $moral_visitante;

	/**
     * Constructora: Inicializar 
     *  id_partido,
     *  local, visitante, turno cronica
     *  ambiente, dif_niveles, aforo_local, aforo_visitante
     * a partir del id_partido de la tabla de partidos
     */
    public Partido($id_partido)
    {
        /* ALEX */
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $partido = Partidos::model()->findByPk($id_partido);
            if ($partido == null)
                throw new CHttpException(404,'Partido inexistente.');

            /*$local = Equipos::model()->findByPk($partido->$equipos_id_equipo_1);
            $visitante = Equipos::model()->findByPk($partido->$equipos_id_equipo_2);

            if ($local == null)
                throw new CHttpException(404,'Equipo local inexistente.');
            if ($visitante == null)
                throw new CHttpException(404,'Equipo visitante inexistente.');*/

            $this->$id_partido = $id_partido;
            $this->$id_local = $partido->equipos_id_equipo_1;
            $this->$id_visitante = $partido->equipos_id_equipo_2;
            $this->$turno = $partido->turno;
            $this->$cronica = $partido->cronica;
            $this->$ambiente = $partido->ambiente;
            $this->$dif_niveles = $partido->nivel_local - $partido->nivel_visitante;
            $this->$aforo_local = $partido->aforo_local;
            $this->$aforo_visitante = $partido->aforo_visitante;
            $this->$ofensivo_local = $partido->ofensivo_local;
            $this->$ofensivo_visitante = $partido->ofensivo_visitante;
            $this->$defensivo_local = $partido->defensivo_local;
            $this->$defensivo_visitante = $partido->defensivo_visitante;
            $this->$goles_local = $partido->goles_local;
            $this->$goles_visitante = $partido->goles_visitante;
            $this->$estado = $partido->estado;
            $this->$moral_local = $partido->moral_local;
            $this->$moral_visitante = $partido->moral_visitante;
            
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }

    /**
     * Funcion que inicializa los atributos 
     *  estado, moral, ofensivo, defensivo y goles
     * cargandolos desde la tabla turnos 
     */
    /*private void cargaEstado()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $turn = Turnos::findByPk($id_partido);

            if ($turn == null)
                throw new CHttpException(404,'Turno inexistente.');

            $ofensivo_local = $turn->$ofensivo_local;
            $ofensivo_visitante = $turn->$ofensivo_visitante;
            $defensivo_local = $turn->$defensivo_local;
            $defensivo_visitante = $turn->$defensivo_visitante;

            $goles_local = $turn->goles_local;
            $goles_visitante = $turn->$goles_visitante;
            $estado = $turn->estado;
            $moral_local = $turn->$moral_local;
            $moral_visitante = $turn->$moral_visitante;
            
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }*/
    
    /*
     * Guarda toda la información del estado actual en la base de datos.
     */
    private void guardaEstado()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $partido = Partidos::findByPk($id_partido);

            if ($partido == null)
                throw new CHttpException(404,'Partido inexistente.');

            $partido->ofensivo_local = $ofensivo_local;
            $partido->ofensivo_visitante = $ofensivo_visitante;
            $partido->defensivo_local = $defensivo_local;
            $partido->defensivo_visitante = $defensivo_visitante;

            $partido->goles_local = $goles_local;
            $partido->goles_visitante = $goles_visitante;
            $partido->estado = $estado;
            $partido->moral_local = $moral_local;
            $partido->moral_visitante = $moral_visitante;
			$partido->turno = $turno;
			$partido->cronica = $cronica;
            if(!$partido->save()) 
                throw new Exception('No se ha podido guardar el turno actual.');
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }

	/**
	 * Estado 0: generar el estado inicial, 
	 * carga las acciones preparatorias y calcula por primera vez 
	 * las variables ambiente, aforos, diferencia de niveles 
	 * y valor ofensivo y defensivo basico de los equipos.
	 * y lo almacena en la tabla turnos.
	 * A partir de la diferencia de niveles, almacena el primer estado
	 * del partido.
	 */
	private void inicializaEncuentro()
	{
		/* ALEX */
		// NOTA: en la tabla <<equipos>> estan los atributos
		// nivel_equipo, factor_ofensivo y factor_defensivo
		$transaction = Yii::app()->db->beginTransaction();
		try{
		/*carga las acciones preparatorias y calcula por primera vez 
		las variables AMBIENTE, AFOROS, DIFERENCIA DE NIVELES 
		y VALOR OFENSIVO y DEFENSIVO basico de los equipos.*/
			$partido = Partidos::model()->findByPk($id_partido);
            if ($partido == null)
                throw new CHttpException(404,'Partido inexistente.');

            $local = Equipos::model()->findByPk($partido->$equipos_id_equipo_1);
            $visitante = Equipos::model()->findByPk($partido->$equipos_id_equipo_2);

            if ($local == null)
                throw new CHttpException(404,'Equipo local inexistente.');
            if ($visitante == null)
                throw new CHttpException(404,'Equipo visitante inexistente.');

            $this->$ambiente = $partido->$ambiente;
            /*niveles de la tabla partidos o de la tabla equipos ?*/
            $this->$dif_niveles = $partido->$nivel_local - $partido->$nivel_visitante;
            $this->$aforo_local = $partido->$aforo_local;
            $this->$aforo_visitante = $partido->$aforo_visitante;
            /*ofensivo y defensivo se inicializan con el valor de la tabal equipos*/
            $ofensivo_local = $local->$factor_ofensivo;
            $ofensivo_visitante = $visitante->$factor_ofensivo;
            $defensivo_local = $local->$factor_defensivo;
            $defensivo_visitante = $visitante->$factor_defensivo;
            $goles_local = 0;
            $goles_visitante = 0;
            //TODO
            $estado = 0; //pelota en medio
            $moral_local = 0;
            $moral_visitante = 0;

            /*
            * ¿Cambiar estado al inicio del partido? Implicaría poder empezar con un gol.
            */
            generar_estado(); //se supone que cambia la variable $estado pero dudo que lo haga
            //revisar cuando acaben la fórmula
			/*y lo almacena en la tabla turnos.
			/*A partir de la diferencia de niveles, almacena el primer estado del partido.*/
			//guardaEstado();
			/*
			* Guardar manualmente el estado: transacción dentro de transacción falla!
			*/
		}catch(Exception $e){
			$transaction->rollback();
			throw $e;
		}
	}

	/*
	 * En función de los datos recogidos para este turno y el estado anterior,
	 * pasa al estado siguiente llamando a un objeto Formula.
	 * Además:
	 * - Actualizar goles en función del estado
	 * - generar cronica del turno
	 *- Mover turno (turno++)
	 */
	private void generar_estado()
	{	
		//Guardamos el estado antiguo para poder generar unas cronicas mejores
		$estado_antiguo = $estado;

		$estado = Formula::siguienteEstado(array('estado'=>$estado, 'difNiv'=>$dif_niveles, 
											'moralLoc'=>$moral_local ,'moralVis'=>$moral_visitante));

		if($estado == null){
			throw new CHttpException(404,'Error en la formula. No se ha calculado bien el siguiente estado');
		}

		
		switch ($estado) {
		    case 10: { //Gol del equipo local
		        $this->$goles_local = $this->$goles_local+1;
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $this->$goles_visitante = $this->$goles_visitante+1;
		        break;
		    }
		    //Default: No ha habido gol, por tanto $this->$estado se queda igual
		}

		self::generaCronicaTurno($estado_antiguo);

		//Si ha habido gol o nos vamos al descanso llamamos a la formula para volver a equilibrar el partido (var $estado)
		//El valor del estado es null porque asi la formula sabe que estamos en estos casos (no podemos volver a meter gol)
		if($estado == 10 || $estado == -10 || $turno == 5){ 
			$estado = Formula::siguienteEstado(array('estado'=>null, 'difNiv'=>$dif_niveles, 
											'moralLoc'=>$moral_local ,'moralVis'=>$moral_visitante));
		}
 
		//Aumentamos turno
		$this->$turno = $this->$turno+1;
		
	}

	/*
	 * Genera la crónica para este turno en función de la crónica acumulada en la BBDD y 
	 * la guarda en la variable $cronica
	 */
	private void generaCronicaTurno($estado_antiguo)
	{
		//variables que necesitamos
		$partido = Partidos::model()->findByPk($id_partido);

		//Decimos en que turno estamos para situar
		$cronica_turno = "Estamos en el turno ".$turno." del partido. ";


		//Miramos a ver si se ha metido algun gol 
		switch ($estado) {
		    case 10: { //Gol del equipo local
		        $cronica_gol = "La aficion del equipo ".$partido->local->nombre." esta muy emocionada. Su equipo ha medido un gol";
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $cronica_gol = "La aficion del equipo ".$partido->visitante->nombre." esta muy emocionada. Su equipo ha medido un gol";
		        break;
		    }
		}

		//Miramos quien va ganando y quien va perdiendo
		switch ($estado) {
			 case ($estado > 0):{ //Va ganando el equipo local
		        $equipo_ganando = $partido->local->nombre.; $equipo_perdiendo = $partido->visitante->nombre.;
		        break;
		    }
		     case ($estado < 0):{ //Va ganando el equipo visitante
		        $equipo_ganando = $partido->visitante->nombre.; $equipo_perdiendo = $partido->local->nombre.;
		        break;
		    }
		    case 0: { //Estan igual
		        $equipo_ganando = ""; $equipo_perdiendo = "";
		        break;
		    }		   
		}

		//Comentamos el estado del partido 
		$cronica_estado;
		$dif_estado = abs($estado - $estado_antiguo);
		switch ($estado) {
		    case 0: { //Gol del equipo local
		        $cronica_estado = "El partido esta es un punto muerto. Nigun equipo es mejor que el otro";
		        break;
		    }
		    case ($dif_estado >=1 && $dif_estado <=3):{ //[1,2,3] Diferencia leve
		        $cronica_estado = "El partido esta prácticamente igualado ".$equipo_ganando." tiene una ligera ventaja";
		        break;
		    }
		    case ($dif_estado >=4 && $dif_estado <=6):{ //[4,5,6] Diferencia normal
				$cronica_estado = "El equipo ".$equipo_ganando." es notablemente superior a ".$equipo_perdiendo;
		        break;
		    }
		    case ($dif_estado >=7 && $dif_estado <=9):{ //[7,8,9] Muy favorable
				$cronica_estado = "El partido esta siendo dominado por .".$equipo_ganando.". ".$equipo_perdiendo." tiene que ponerse las pilas";
		        break;
		    }
		}

		//Comentamos la diferencia entre el estado antiguo y el actual
		$cronica_dif_estado;
		$dif_estado = abs($estado - $estado_antiguo);
		switch ($dif_estado) {
		    case ($dif_estado == 0): { //El partido sigue igual
		    	$cronica_dif_estado = "El partido sigue igual que antes. Nada ha cambiado. Esta muy reñido"
		        break;
		    }
		    case ($dif_estado >=1 && $dif_estado <=3):{ //[1,2,3] Diferencia leve
				$cronica_dif_estado = "El partido está muy reñido. EL equipo ha mejorado su posicion ligeramente"
		        break;
		    }
		    case ($dif_estado >=4 && $dif_estado <=6):{ //[4,5,6] Diferencia ligera
				$cronica_dif_estado = "La táctica de juego ha cambiado y el equipo ha mejorado su posicion."
		        break;
		    }
		    case ($dif_estado >=7 && $dif_estado <=9):{ //[7,8,9] Ventaja para alguien
				$cronica_dif_estado = "La táctica de juego ha cambiado y el equipo ha mejorado su posicion notablemente."
		        break;
		    }
		    case ($dif_estado >=10 && $dif_estado <=13):{ //[10,11,12,13] Remontada 
				"El equipo se ha posicionado en la delantera. Una pequeña remontada. Pero deben estar atentos si no quieren que el esfuerzo caiga en saco roto."
		        break;
		    }
		    case ($dif_estado >=14 && $dif_estado <=16):{ //[14,15,16] Remontada importante 
				"El equipo se ha posicionado en la delantera. Una pequeña remontada. Si se esfuerzan un poco más conseguiran gol"
		        break;
		    }
		    case ($dif_estado >=17 && $dif_estado <=19):{ //[17,18,19] Remontada brutal
				$cronica_dif_estado = "El equipo ha dado la vuelta al juego de una manera increible. Una remontada brutal. Ya se huele el gol"
		        break;
		    }
		    case ($dif_estado == 20 ):{ //[20] En el estado antetior unos metiron gol y ahora los otros han remontado. 
				$cronica_dif_estado = "El equipo ha dado la vuelta al juego de una manera increible. Una remontada brutal que hace que el gol de antes quede en nada."
		        break;
		    }
		}

		//TODO comentar la diferencia de goles

		
		$this->$cronica = $cronica_turno." ".$cronica_gol." ".$cronica_estado." ".$cronica_dif_estado;
		
	}

	/*
	 * Genera una crónica inicial para el partido.
	 */
	private void generaCronicaBase()
	{
		
	}

	/*
	 * 1. Da una bonificacion por el encuentro
	 * 2. Desactiva las entradas compradas por los usuarios -> DE MOMENTO OLVIDARLO
	 * 3. Actualizar clasificación
	 */
	private void finalizaEncuentro()
	{
		generaBonificacion();
		actualizaClasificacion();
	}

	/*
	 * Genera una bonificación de recursos a los participantes del partido en 
	 * función del resultado y el ambiente.
	 */
	private void generaBonificacion()
	{
		/* MARCOS */
		/*$bonifGanador = 28;
		  $bonifEmpate = 14;
		  $bonifPerdedor = 7;*/
		if($goles_local>$goles_visitante){
			bonifAnimo($id_local, 28);
			bonifAnimo($id_visitante, 7);
		}elseif($goles_visitante>$goles_local){
			bonifAnimo($id_visitante, 28);
			bonifAnimo($id_local, 7);
		}else{
			bonifAnimo($id_local, 14);
			bonifAnimo($id_visitante, 14);
		}
	}

	/*
	 * Se usa exclusivamente como paso intermedio de generaBonificacion.
	 *
	 * Dado un $id_equipo y un $bonus, da una bonificación de animo a los miembros del $id_equipo. 
	 * bonificacion = [(1.5^(ambiente+1))/(4+.7*ambiente)] * bonus * (haParticipado?3:1)
	 */
	private void bonifAnimo($equipo, int $bonus)
	{
		/*$bonifParticipante = 3;
		  $bonifNoParticipante = 1*/

		  /*
		  *
		  * REVISAR, NO HAY ACCIONESTURNO -> ¿Cómo marcar los que han participado?
		  *
		  */
		$trans = Yii::app()->db->beginTransaction();
		try{
			$participantes=AccionesTurno::model()->findByAllAttributes(array('equipos_id_equipo'=>$equipo, 'partidos_id_partido'=>$id_partido)),
			$usuarios=Usuarios::model()->findAllByAtributes(array('equipos_id_equipo'=>$equipo));
			$bonusAmbiente = $bonus* (pow(1.5, $ambiente+1)/(4+.7*$ambiente));//(1.5^(a+1))/(4+.7*a)
			
			foreach ($usuarios as $user){//Esta bonificacion se le da a todos
				$rec=Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>$user));
				$rec['animo']= min(round(  $bonusAmbiente+$rec['animo']), $rec['animo_max']);
				$rec->save();
			}
			foreach ($participantes as $user){//Esta se le da solo a los participantes
				$rec=Recursos::model()->findByAttributes(array('usuarios_id_usuario'=>$user));
				$rec['animo']= min(round(2*$bonusAmbiente+$rec['animo']), $rec['animo_max']);
				$rec->save();
			}
			$trans->commit();
		}catch(Exception $exc){
			$trans->rollback();
			//Yii::log('[MATCH_ERROR].'.$exc->getMessage(), 'error');
			throw new Exception("Error al generar la bonificacion al animo de final de partido", 1);
		}
	}

	/*
	 * Recalcula los puntos y actualiza la clasificación.
	 */
	private void actualizaClasificacion()
	{			
		$trans = Yii::app()->db->beginTransaction();
		try{
			$loc=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=>$id_local));
			$vis=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=>$id_visitante));
			
			if($goles_local>$goles_visitante){
				$suCl=sumaCalisf($id_local, 3, $trans);
				$loc['ganados']+=1;
				$vis['perdidos']+=1;
			}elseif($goles_visitante>$goles_local){
				$suCl=sumaCalisf($id_visitante, 3, $trans);
				$loc['perdidos']+=1;
				$vis['ganados']+=1;	
			}else{
				$suCl= sumaCalisf($id_local, 1, $trans) && sumaCalisf($id_visitante, 1, $trans);
				$loc['empatados']+=1;
				$vis['empatados']+=1;	
			}
			$loc->save();
			$vis->save();
			if(!$suCl)throw new Exception("Error en sumaCalisf");
			$trans->commit();	
		}catch(Exception $exc){
			$trans->rollback();
			throw new Exception("Error al recalcular la clasificación", 1);
		}

	}
	
	/*
	 * Se usa exclusivamente como paso intermedio de actualizaClasificacion.
	 *
	 * Suma $puntos a $id_equipo en la tabla de clasificacion y reordena.
	 * 
	 * @returns si la transaccion ha terminado con exito o no.
	 *
	 * Si se le pasa una transaccion activa, no commita los cambios 
	 * (espera a que los commite quien inició la transacion).
	 */
	private bool sumaCalisf($id_equipo, int $puntos, &$transaction=null)
	{	
		if($transaction==null) {
			$transaction= Yii::app()->db->beginTransaction();
			$autocommit=true;
		}else $autocommit=false;

		if(!($transaction instaceof CDbTransaction && $transaction->getActive()) )
			return false;

		try{
			//sumar puntos
			$eq= Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=>$id_equipo));
			$puntosAnt= $eq['puntos'];
			$puntosAct= ($eq['puntos']+=$puntos);

			//Actualizar todos los equipos desplazados
			$criteria= new CDbCriteria();
			$criteria->condition=("puntos>=:puntosAnt && puntos< :puntosAct");
			$criteria->params=array(':puntosAnt'=>$puntosAnt, ':puntosAct'=>$puntosAct);
			$clas= Clasificacion::model()->findAll($criteria);
			foreach ($clas as $e){
				 $e['posicion']+=1;
				 $e->save();
			}

			//Calcula la nueva 'posicion' del equipo
			$criteria= new CDbCriteria();
			$criteria->select='MAX(posicion) as posMax';
			$criteria->condition='puntos>:puntosAct';
			$criteria->params=array(':puntosAct'=>$puntosAct);
			$clas= Clasificacion::model()->find($criteria);
			$eq['posicion']= ($clas==null)? 1: $clas['posMax']+1;

			$eq->save();
			if($autocommit)$transaction->commit();

		}catch(Exception $exc){
			if($autocommit)$transaction->rollback();
			return false;
		}
		return true;
	}

	public void jugarse()
	{
		switch ($turno) 
		{
		    case PRIMER_TURNO:	
		    	//Turno inicial (preparar partido)		
		    	inicializaEncuentro();  
		    	generaCronicaBase();
		    	guardaEstado();      
		        break;
		    case (($turno > PRIMER_TURNO) && ($turno < ULTIMO_TURNO)):	
		    	//Turnos de partido
		    	//cargaEstado();
				//recogeAccionesTurno();
				generar_estado();
				//generaCronicaTurno();
				guardaEstado();
		        break;
		    case ULTIMO_TURNO:
		    	//Turno final, la diferencia es que ya no ofrecemos el extra de recursos
		    	//sino que ofrecemos la bonificacion por asistir/ganar.
		    	//cargaEstado();
				//recogeAccionesTurno();
				generar_estado();
				//generaCronicaTurno();
				finalizaEncuentro();
				guardaEstado();
		    	break;
		    default:
		       	// No debería llegar aquí
		    	echo "Jodimos algo";
		}
	}
}
