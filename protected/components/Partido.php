<?php
/**
*
* CLASE PARA EL PARTIDO
*
*/
class Partido
{
	/* Un partido se juega entre los turnos 1 - 10 
	* El turno 0 es inicialización de partido.
	* El turno 6 es de descanso del partido.
	*/
	const PRIMER_TURNO = 0;
	const ULTIMO_TURNO = 11;
	const TURNO_DESCANSO = 6;

	const AMBIENTE_MEDIO = 500;

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
    function Partido($id_partido)
    {
        /* ALEX */
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $partido = Partidos::model()->findByPk($id_partido);
            if ($partido == null)
                throw new CHttpException(404,'Partido inexistente.');
            $this->id_partido = $id_partido;
            $this->id_local = $partido->equipos_id_equipo_1;
            $this->id_visitante = $partido->equipos_id_equipo_2;
            $this->turno = $partido->turno;
            $this->cronica = $partido->cronica;
            $this->ambiente = $partido->ambiente;
            $this->dif_niveles = $partido->dif_niveles;
            $this->aforo_local = $partido->aforo_local;
            $this->aforo_visitante = $partido->aforo_visitante;
            $this->ofensivo_local = $partido->ofensivo_local;
            $this->ofensivo_visitante = $partido->ofensivo_visitante;
            $this->defensivo_local = $partido->defensivo_local;
            $this->defensivo_visitante = $partido->defensivo_visitante;
            $this->goles_local = $partido->goles_local;
            $this->goles_visitante = $partido->goles_visitante;
            $this->estado = $partido->estado;
            $this->moral_local = $partido->moral_local;
            $this->moral_visitante = $partido->moral_visitante;
            
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
    private function guardaEstado()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $partido = Partidos::model()->findByPk($this->id_partido);


            if ($partido == null)
                throw new CHttpException(404,'Partido inexistente.');

            $partido->ofensivo_local = $this->ofensivo_local;
            $partido->ofensivo_visitante = $this->ofensivo_visitante;
            $partido->defensivo_local = $this->defensivo_local;
            $partido->defensivo_visitante = $this->defensivo_visitante;

            $partido->goles_local = $this->goles_local;
            $partido->goles_visitante = $this->goles_visitante;
            $partido->estado = $this->estado;
            $partido->moral_local = $this->moral_local;
            $partido->moral_visitante = $this->moral_visitante;
			$partido->turno = $this->turno;
			$partido->cronica = $this->cronica;
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
	private function inicializaEncuentro()
	{
		//Fijar turno inicial
		$this->turno = 1;
		//Fijar goles iniciales por seguridad
		$this->goles_local = 0;
		$this->goles_visitante = 0;
		//Generamos estado inicial del partido

		//$this->estado = Formula::siguienteEstado(/*PARAMS*/);

		//Tomar fijos datos locales y visitantes
		$local = Equipos::model()->findByPk($this->id_local);
        $visitante = Equipos::model()->findByPk($this->id_visitante);   
        $partido = Partidos::model()->findByPk($this->id_partido);
        //Comprobación de existencia de datos por seguridad
        if ($local == null)
            throw new CHttpException(404,'Equipo local inexistente.');
        if ($visitante == null)
            throw new CHttpException(404,'Equipo visitante inexistente.');     
        if ($partido == null)
            throw new CHttpException(404,'Partido inexistente.');
        //Fijar diferencia de niveles.
        //IMPORTANTE: dif. niveles -> Local +, Visitante -
        $this->dif_niveles = $partido->nivel_local - $partido->nivel_visitante;
        //Fijar factores ofensivo y defensivo
        $this->ofensivo_local = $local->factor_ofensivo;
        $this->defensivo_local = $local->factor_defensivo;
        $this->ofensivo_visitante = $visitante->factor_ofensivo;
        $this->defensivo_visitante = $visitante->factor_defensivo;
        //Moral inicial
        $this->moral_local = 0;
        $this->moral_visitante = 0;

        //Ambiente, aforo local y visitante ya tomados en la constructora.
        //Pertenecen a Partidos desde el comienzo.
	}

	/*
	 * En función de los datos recogidos para este turno y el estado anterior,
	 * pasa al estado siguiente llamando a un objeto Formula.
	 * Además:
	 * - Actualizar goles en función del estado
	 * - generar cronica del turno
	 *- Mover turno (turno++)
	 */
	private function generar_estado()
	{	
		//Guardamos el estado antiguo para poder generar unas cronicas mejores
		$estado_antiguo = $this->estado;

		$this->estado = Formula::siguienteEstado(array('estado'=>3, 'difNiv'=>5, 
											'moralLoc'=>7 ,'moralVis'=>2));

		/*$this->estado = Formula::siguienteEstado(array('estado'=>null, 'difNiv'=>$dif_niveles, 
											'moralLoc'=>$moral_local ,'moralVis'=>$moral_visitante)); */

		 /*$params = array(
 			'difNiv'    => (double) 3, 'aforoMax'  => (double) 3,
 			'aforoLoc'  => (double) 3 , 'aforoVis'  => (double) 3,
			'moralLoc'  => (double) 4, 'moralVis'  => (double) 3,
			'ofensLoc'  => (double) 4, 'ofensVis'  => (double) 3,
			'defensLoc' => (double) 4, 'defensVis' => (double) 3,
			'estado'    => (double) 5,
		);  


		$this->estado = Formula::siguienteEstado($params); */

		if($this->estado == null){
			throw new CHttpException(404,'Error en la formula. No se ha calculado bien el siguiente estado');
		}

		
		switch ($this->estado) {
		    case 10: { //Gol del equipo local
		        $this->goles_local = $this->goles_local+1;
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $this->goles_visitante = $this->goles_visitante+1;
		        break;
		    }
		    //Default: No ha habido gol, por tanto $this->estado se queda igual
		}

		self::generaCronicaTurno($estado_antiguo);

		//Si ha habido gol o nos vamos al descanso llamamos a la formula para volver a equilibrar el partido (var $estado)
		//El valor del estado es null porque asi la formula sabe que estamos en estos casos (no podemos volver a meter gol)
		if($this->estado == 10 || $this->estado == -10 || $this->turno == 5){ 
			/*$estado = Formula::siguienteEstado(array('estado'=>null, 'difNiv'=>$dif_niveles, 
											'moralLoc'=>$moral_local ,'moralVis'=>$moral_visitante)); */
		}
 
		//Aumentamos turno
		$this->turno = $this->turno+1;
		
	}

	/*
	 * Genera la crónica para este turno en función de la crónica acumulada en la BBDD y 
	 * la guarda en la variable $cronica
	 */

	private function generaCronicaTurno($estado_antiguo)
	{
		//variables que necesitamos
		$partido = Partidos::model()->findByPk($this->id_partido);

		//Decimos en que turno estamos para situar
		$cronica_turno = "Estamos en el turno ".$this->turno." del partido. ";


		//Miramos a ver si se ha metido algun gol 
		$cronica_gol = "";
		switch ($this->estado) {
		    case 10: { //Gol del equipo local
		        $cronica_gol = " La aficion del equipo ".$partido->local->nombre." esta muy emocionada. Su equipo ha medido un gol";
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $cronica_gol = " La aficion del equipo ".$partido->visitante->nombre." esta muy emocionada. Su equipo ha medido un gol";
		        break;
		    }
		}

		//Miramos quien va ganando y quien va perdiendo
		switch ($this->estado) {
			 case ($this->estado > 0):{ //Va ganando el equipo local
		        $equipo_ganando = $partido->local->nombre; $equipo_perdiendo = $partido->visitante->nombre;
		        break;
		    }
		     case ($this->estado  < 0):{ //Va ganando el equipo visitante
		        $equipo_ganando = $partido->visitante->nombre; $equipo_perdiendo = $partido->local->nombre;
		        break;
		    }
		    case 0: { //Estan igual
		        $equipo_ganando = ""; $equipo_perdiendo = "";
		        break;
		    }		   
		}

		//Comentamos el estado del partido 
		$cronica_estado = "";
		switch (abs($this->estado)) {
		    case 0: { //Gol del equipo local
		        $cronica_estado = " El partido esta es un punto muerto. Nigun equipo es mejor que el otro";
		        break;
		    }
		    case ($this->estado >=1 && $this->estado <=3):{ //[1,2,3] Diferencia leve
		        $cronica_estado = " El partido esta prácticamente igualado ".$equipo_ganando." tiene una ligera ventaja";
		        break;
		    }
		    case ($this->estado >=4 && $this->estado <=6):{ //[4,5,6] Diferencia normal
				$cronica_estado = " El equipo ".$equipo_ganando." es notablemente superior a ".$equipo_perdiendo;
		        break;
		    }
		    case ($this->estado >=7 && $this->estado <=9):{ //[7,8,9] Muy favorable
				$cronica_estado = " El partido esta siendo dominado por .".$equipo_ganando.". ".$equipo_perdiendo." tiene que ponerse las pilas";
		        break;
		    }
		}

		//Miramos quien, en este turno, ha mejorado su posicion
		if($this->estado > $estado_antiguo ){ // el equipo local ha mejorado su situacion en el partido en la ultima jugada  
			$equipo_mejorado = $partido->local->nombre; $equipo_empeorado = $partido->visitante->nombre;
		}
		else{ //el equipo visitante ha mejorado su situacion en el partido en la ultima jugada
			$equipo_mejorado = $partido->visitante->nombre; $equipo_empeorado = $partido->local->nombre;
		}


		//Comentamos la diferencia entre el estado antiguo y el actual
		$cronica_dif_estado = "";
		$dif_estado = abs($this->estado - $estado_antiguo);
		switch ($dif_estado) {
		    case ($dif_estado == 0): { //El partido sigue igual
		    	$cronica_dif_estado = " El partido sigue igual que antes. Nada ha cambiado. Esta muy reñido";
		        break;
		    }
		    case ($dif_estado >=1 && $dif_estado <=3):{ //[1,2,3] Diferencia leve
				$cronica_dif_estado = " El partido está muy reñido. El equipo ".$equipo_mejorado." ha mejorado su posicion ligeramente.";
		        break;
		    }
		    case ($dif_estado >=4 && $dif_estado <=6):{ //[4,5,6] Diferencia ligera
				$cronica_dif_estado = " La táctica de juego ha cambiado y el equipo ".$equipo_mejorado." ha mejorado su posicion.";
		        break;
		    }
		    case ($dif_estado >=7 && $dif_estado <=9):{ //[7,8,9] Ventaja para alguien
				$cronica_dif_estado = " La táctica de juego ha cambiado y el equipo ".$equipo_mejorado." ha mejorado su posicion notablemente.";
		        break;
		    }
		    case ($dif_estado >=10 && $dif_estado <=13):{ //[10,11,12,13] Remontada 
				" El equipo ".$equipo_mejorado." se ha posicionado en la delantera. Una pequeña remontada. Pero deben estar atentos si no quieren que el esfuerzo caiga en saco roto.";
		        break;
		    }
		    case ($dif_estado >=14 && $dif_estado <=16):{ //[14,15,16] Remontada importante 
				" El equipo ".$equipo_mejorado." se ha posicionado en la delantera. Una pequeña remontada. Si se esfuerzan un poco más conseguiran gol.";
		        break;
		    }
		    case ($dif_estado >=17 && $dif_estado <=19):{ //[17,18,19] Remontada brutal
				$cronica_dif_estado = " El equipo ".$equipo_mejorado." ha dado la vuelta al juego de una manera increible. Una remontada brutal. Ya se huele el gol.";
		        break;
		    }
		    case ($dif_estado == 20 ):{ //[20] En el estado antetior unos metiron gol y ahora los otros han remontado. 
				$cronica_dif_estado =  " El equipo ".$equipo_mejorado." ha dado la vuelta al juego de una manera increible. Una remontada brutal que hace que el gol de ".$equipo_empeorado." quede en nada.";
		        break;
		    }
		}

		//TODO comentar la diferencia de goles

		
		$this->cronica .= $cronica_turno.$cronica_gol.$cronica_estado.$cronica_dif_estado;
		
	}

	/*
	 * Genera una crónica inicial para el partido.
	 */
	private function generaCronicaBase()
	{
		//Tomar fijos datos locales y visitantes
		$local = Equipos::model()->findByPk($this->id_local);
        $visitante = Equipos::model()->findByPk($this->id_visitante);  
        //Comprobación de existencia de datos por seguridad
        if ($local == null)
            throw new CHttpException(404,'Equipo local inexistente.');
        if ($visitante == null)
            throw new CHttpException(404,'Partido inexistente.');
		$this->cronica .= "Comienza el encuentro entre los ".$local->nombre." como locales y los ".$visitante->nombre." en posición de visitantes. ";
		$this->cronica .= ($this->aforo_local > 2*$this->aforo_visitante) ? "Por lo visto no ha habido demasiados desplazamientos en el equipo visitante. El estadio se llena con los colores de los ".$local->nombre.". " : "";  
		$this->cronica .= ($this->ambiente > self::AMBIENTE_MEDIO) ? "El ambiente está caldeado y la afición espera con ganas ver a su equipo en acción. " : 
		"Los ánimos brillan por su ausencia. Ambas aficiones parecen estar apagadas. Parece que no se jueguen mucho en este encuentro. "; 
		$this->cronica .= ($this->estado > 0) ? "El equipo local empieza con superioridad, esperemos que aguanten así todo el partido." : 
		"El equipo visitante empieza con superioridad, esperemos que aguanten así todo el partido. ";  
	}

	/*
	 * 1. Da una bonificacion por el encuentro
	 * 2. Desactiva las entradas compradas por los usuarios -> DE MOMENTO OLVIDARLO
	 * 3. Actualizar clasificación
	 */
	private function finalizaEncuentro()
	{
		$this->generaBonificacion();
		$this->actualizaClasificacion();
	}

	/*
	 * Genera una bonificación de recursos a los participantes del partido en 
	 * función del resultado y el ambiente.
	 */
	private function generaBonificacion()
	{
		/* MARCOS */
		/*$bonifGanador = 28;
		  $bonifEmpate = 14;
		  $bonifPerdedor = 7;*/
		if($this->goles_local>$this->goles_visitante){
			$this->bonifAnimo($this->id_local, 28);
			$this->bonifAnimo($this->id_visitante, 7);
		}elseif($this->goles_visitante>$this->goles_local){
			$this->bonifAnimo($this->id_visitante, 28);
			$this->bonifAnimo($this->id_local, 7);
		}else{
			$this->bonifAnimo($this->id_local, 14);
			$this->bonifAnimo($this->id_visitante, 14);
		}
	}

	/*
	 * Se usa exclusivamente como paso intermedio de generaBonificacion.
	 *
	 * Dado un $id_equipo y un $bonus, da una bonificación de animo a los miembros del $id_equipo. 
	 * bonificacion = [(1.5^(ambiente+1))/(4+.7*ambiente)] * bonus * (haParticipado?3:1)
	 */
	private function bonifAnimo($equipo, $bonus)
	{
		/*$bonifParticipante = 3;
		  $bonifNoParticipante = 1*/
		$trans = Yii::app()->db->beginTransaction();
		try{
			$participantes=AccionesTurno::model()->findAllByAttributes(array('equipos_id_equipo'=>$equipo, 'partidos_id_partido'=>$this->id_partido));
			$usuarios=Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$equipo));
			$bonusAmbiente = $bonus* (pow(1.5, $this->ambiente+1)/(4+.7*$this->ambiente));//(1.5^(a+1))/(4+.7*a)
			
			foreach ($usuarios as $user){//Esta bonificacion se le da a todos
				$rec=$user->recursos;
				$rec['animo']= min(round(  $bonusAmbiente+$rec['animo']), $rec['animo_max']);
				$rec->save();
			}
			foreach ($participantes as $participante){//Esta se le da solo a los participantes
				$user=$participante->usuarios;
				$rec=$user->recursos;
				$rec['animo']= min(round(3*$bonusAmbiente+$rec['animo']), $rec['animo_max']);
				$rec->save();
			}
			$trans->commit();
		}catch(Exception $exc){
			$trans->rollback();
			echo $exc; Yii::app()->end();
			//Yii::log('[MATCH_ERROR].'.$exc->getMessage(), 'error');
			throw new Exception("Error al generar la bonificacion al animo de final de partido", 1);
		}
	}

	/*
	 * Recalcula los puntos y actualiza la clasificación.
	 */
	private function actualizaClasificacion()
	{			
		$trans = Yii::app()->db->beginTransaction();
		try{
			$local=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=> $this->id_local));
			$visit=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=> $this->id_visitante));

			//Miro quien ha ganado el partido 
			//Sumo los puntos y los goles a favor y en contra de cada equipo
			if($this->goles_local>$this->goles_visitante)
			{
				$puntosLocal=$local->puntos;
				$puntosLocal=$puntosLocal+3;
				$local->setAttributes(array('puntos'=>$puntosLocal));         
			}else if($this->goles_local<$this->goles_visitante)
					{
						$puntosVisitante=$visit->puntos;
						$puntosVisitante=$puntosVisitante+3;
						$visit->setAttributes(array('puntos'=>$puntosVisitante)); 
					}else 
						{
							$puntosLocal=$local->puntos;
							$puntosLocal=$puntosLocal+1;							
							$puntosVisitante=$visit->puntos;
							$puntosVisitante=$puntosVisitante+1;
							$local->setAttributes(array('puntos'=>$puntosLocal)); 
							$visit->setAttributes(array('puntos'=>$puntosVisitante));							
						}

			//una vez actualizado los puntos, toca actualizar las diferencia de goles
			$difPartidoLocal=$this->goles_local-$this->goles_visitante;
			$difPartidoVisit=$this->goles_visitante-$this->goles_local;
			$difTablaLocal=$local->diferencia_goles;
			$difTablaVisit=$visit->diferencia_goles;
			$local->setAttributes(array('diferencia_goles'=>$difTablaLocal+$difPartidoLocal)); 
			$visit->setAttributes(array('diferencia_goles'=>$difTablaVisit+$difPartidoVisit));
			$visit->save();
			$local->save(); 	

			//Una vez hecho esto,voy a la clasificacion y recalculo las posiciones
			//Para ello voy a coger ahora todos los registros de clasificacion
			//Y utilizando ORDER BY en la consulta voy a ir colocando las posiciones
			//Con respecto a los puntos y a la diferencia de goles
			$criteria = new CDbCriteria();
			$criteria->order = 'puntos DESC,diferencia_goles DESC';

			/*Otra opcion puede ser esta
			$Puestos = Clasificacion::model()->findAll(
			array('order'=>'puntos ASC,diferencia_goles DESC'));*/
			$puestos=Clasificacion::model()->findAll($criteria);
			$i=1;
			foreach ($puestos as $puesto)
			{
				$puesto->posicion=$i;
				$i++;
				$puesto->save();
			}



			$trans->commit();	
		}catch(Exception $exc){
			$trans->rollback();			
			throw new Exception("Error al recalcular la clasificación", 1);
		}

	}
	
	private function generaCronicaDescanso()
	{
		//Indicar fin del descanso y reanudación del partido
		$this->cronica .= "Finaliza el descanso y ambos equipos vuelven al terreno de juego. El partido se reanuda. ";
		$this->cronica .= ($this->estado > 0) ? "El equipo local continua el juego con superioridad, esperemos que aguanten así el resto de la segunda parte." : 
		"El equipo visitante continua el juego con superioridad, esperemos que aguanten así el resto de la segunda parte. "; 
	}

	private function generaEstadoDescanso()
	{
		//Generamos estado tras el descanso
		//$this->estado = Formula::siguienteEstado(/*PARAMS*/);
		$this->turno++;
	}

	public function jugarse()
	{
		switch ($this->turno) 
		{
		    case self::PRIMER_TURNO:	
		    	//Turno inicial (preparar partido)		
		    	$this->inicializaEncuentro();  
		    	$this->generaCronicaBase();
		    	$this->guardaEstado();      
		        break;
		    case self::TURNO_DESCANSO:
		    	//TODO Revisar!!!
		    	$this->generaEstadoDescanso();
		    	$this->generaCronicaDescanso();
		    	$this->guardaEstado();
		    	break;
		    case (($this->turno > self::PRIMER_TURNO) 
		    	&& ($this->turno < self::ULTIMO_TURNO) 
		    	&& ($this->turno != self::TURNO_DESCANSO)):	
		    	//Este apartado incluye el descanso del partido!
		    	//Turnos de partido
				$this->generar_estado();
				$this->guardaEstado();
		        break;
		    case self::ULTIMO_TURNO:
		    	//Turno final, la diferencia es que ya no ofrecemos el extra de recursos
		    	//sino que ofrecemos la bonificacion por asistir/ganar.
				$this->generar_estado();
				$this->finalizaEncuentro();
				$this->guardaEstado();
		    	break;
		    default:
		       	// No debería llegar aquí
		    	echo "Jodimos algo";
		}
	}
}
