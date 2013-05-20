<?php

/**
 * Clase que contiene la logica de un partido
 *
 * Reparto de los turnos
 *
 * - turno 0 : turno de inicializacion
 * - turnos 1 - 5 : turnos de juego (1 parte)
 * - turno 6 : turno del descanso 
 * - turnos 7 - 11 : turnos de juego (2 parte)
 * - turno 12 : turno de finalizacion -> NO USADO YA
 *
 *
 * @package componentes
 */
class Partido
{
	/** turno de inicializacion del partido */
	const PRIMER_TURNO = 0;
	/** turno de finalizacion del partido */
	const ULTIMO_TURNO = 11;//12;
	/** turno para el descanso */
	const TURNO_DESCANSO = 6;

	/** puntuacion de ambiente estandar */
	const AMBIENTE_MEDIO = 500;

	/** @type int */
	private $id_partido;
	/** @type int */
	private $id_local;
	/** @type int */
	private $id_visitante;
	/** @type int */
	private $turno;
	/** @type string */
	private $cronica;
	/** @type int */
	private $ambiente;
	/** @type int */
	private $dif_niveles;
	/** @type int */
	private $aforo_local;
	/** @type int */
	private $aforo_visitante;

	/** @type int */
	private $ofensivo_local;
    /** @type int */
	private $ofensivo_visitante;
    /** @type int */
	private $defensivo_local;
    /** @type int */
	private $defensivo_visitante;
	
    /** @type int */
	private $goles_local;
    /** @type int */
	private $goles_visitante;
    /** @type int */
	private $estado;
    /** @type int */
	private $moral_local;
    /** @type int */
	private $moral_visitante;

	/**
     * Inicializar los atributos del objeto partido
     *
     * > Consulta la tabla Partidos
     *
     * @param int $id_partido   id del partido
     * @throws \Exception       partido inexistente
     * @return void
     */
    function Partido($id_partido)
    {
        $partido = Partidos::model()->findByPk($id_partido);
        if ($partido === null)
            throw new Exception('Partido inexistente.',404);
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
    }
    
    /**
     * Guarda toda la información del estado actual en la base de datos
     *
     * @throws \Exception   partido inexistente
     * @throws \Exception   fallo al guardar el turno actual en la BD
     * @return void
     */
    private function guardaEstado()
    {
        $partido = Partidos::model()->findByPk($this->id_partido);
        if ($partido === null)
            throw new Exception('Partido inexistente.',404);

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
		$partido->hora_ult_turno = time();
        if(!$partido->save()) 
            throw new Exception('No se ha podido guardar el turno actual.');
    }

	/**
	 * Generar el estado inicial del partido (primer estado del partido)
     *
     * - fija el turno del partido a 1 
	 * - carga las acciones preparatorias 
     * - calcula las variables de ambiente, aforos y diferencia de niveles
	 * - carga el valor ofensivo y defensivo basico de los equipos
     *
     * @throws \Exception Equipo local/visitante no encontrado
     * @throws \Excepction Partido no encontrado
     * @return void
	 */
	private function inicializaEncuentro()
	{
		//Fijar turno inicial
		$this->turno = 1;
		//Fijar goles iniciales por seguridad
		$this->goles_local = 0;
		$this->goles_visitante = 0;
		//Tomar fijos datos locales y visitantes
		$local = Equipos::model()->findByPk($this->id_local);
        $visitante = Equipos::model()->findByPk($this->id_visitante);   
        $partido = Partidos::model()->findByPk($this->id_partido);
        //Comprobación de existencia de datos por seguridad
        if ($local === null)
            throw new Exception('Equipo local inexistente.',404);
        if ($visitante === null)
            throw new Exception('Equipo visitante inexistente.',404);     
        if ($partido === null)
            throw new Exception('Partido inexistente.',404);
        //Fijar diferencia de niveles.
        //IMPORTANTE: dif. niveles -> Local +, Visitante -
        $this->dif_niveles = $partido->nivel_local - $partido->nivel_visitante;
        //Fijar factores ofensivo y defensivo
        /*$this->ofensivo_local = $local->factor_ofensivo;
        $this->defensivo_local = $local->factor_defensivo;
        $this->ofensivo_visitante = $visitante->factor_ofensivo;
        $this->defensivo_visitante = $visitante->factor_defensivo;*/
        $this->ofensivo_local = $this->ofensivo_local;
        $this->defensivo_local = $this->defensivo_local;
        $this->ofensivo_visitante = $this->ofensivo_visitante;
        $this->defensivo_visitante = $this->defensivo_visitante;
        //Moral inicial
        $this->moral_local = $this->moral_local;
        $this->moral_visitante = $this->moral_visitante;
		//Generamos estado inicial del partido

        $params = array(
 			'difNiv'    => (double) $this->dif_niveles, 'aforoMax'  => (double) 0,
 			'aforoLoc'  => (double) $this->aforo_local, 'aforoVis'  => (double) $this->aforo_visitante,
			'moralLoc'  => (double) $this->moral_local, 'moralVis'  => (double) $this->moral_visitante,
			'ofensLoc'  => (double) $this->ofensivo_local, 'ofensVis'  => (double) $this->ofensivo_visitante,
			'defensLoc' => (double) $this->defensivo_local, 'defensVis' => (double) $this->defensivo_visitante,
			'estado'    => null
		);

		$this->estado = Formula::siguienteEstado($params);


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

		$params = array(
 			'difNiv'    => (double) $this->dif_niveles, 'aforoMax'  => (double) 0,
 			'aforoLoc'  => (double) $this->aforo_local, 'aforoVis'  => (double) $this->aforo_visitante,
			'moralLoc'  => (double) $this->moral_local, 'moralVis'  => (double) $this->moral_visitante,
			'ofensLoc'  => (double) $this->ofensivo_local, 'ofensVis'  => (double) $this->ofensivo_visitante,
			'defensLoc' => (double) $this->defensivo_local, 'defensVis' => (double) $this->defensivo_visitante,
			'estado'    => (double) $this->estado
		);

		$this->estado = Formula::siguienteEstado($params);

		if($this->estado === null){
			throw new Exception('Error en la formula. No se ha calculado bien el siguiente estado. NULL',404);
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

			$params = array(
	 			'difNiv'    => (double) $this->dif_niveles, 'aforoMax'  => (double) 0,
	 			'aforoLoc'  => (double) $this->aforo_local, 'aforoVis'  => (double) $this->aforo_visitante,
				'moralLoc'  => (double) $this->moral_local, 'moralVis'  => (double) $this->moral_visitante,
				'ofensLoc'  => (double) $this->ofensivo_local, 'ofensVis'  => (double) $this->ofensivo_visitante,
				'defensLoc' => (double) $this->defensivo_local, 'defensVis' => (double) $this->defensivo_visitante,
				'estado'    => (double) $this->estado
			);

			$this->estado = Formula::siguienteEstado($params);
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
		if ($this->turno > self::TURNO_DESCANSO)
		{
			$cronica_turno = "Turno: ".($this->turno - 1).".";
		}
		else
		{
			$cronica_turno = "Turno: ".$this->turno.".";
		}


		//Miramos a ver si se ha metido algun gol 
		$cronica_gol = "";
		switch ($this->estado) {
		    case 10: { //Gol del equipo local
		        $cronica_gol = " La aficion del equipo ".$partido->local->nombre." esta muy emocionada. Su equipo ha metido un gol.";
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $cronica_gol = " La aficion del equipo ".$partido->visitante->nombre." esta muy emocionada. Su equipo ha metido un gol.";
		        break;
		    }
		}

		//Miramos quien va ganando y quien va perdiendo
		switch ($this->estado) {
			 case ($this->estado > 0):{ //Va ganando el equipo local
		        $equipo_ganando = $partido->local->nombre; $equipo_perdiendo = $partido->visitante->nombre;
		        break;
		    }
		     case ($this->estado < 0):{ //Va ganando el equipo visitante
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
		$abs_estado=abs($this->estado);
		switch ($abs_estado) {
		    case 0: { 
		        $cronica_estado = " El partido está en un punto muerto. Ningún equipo es mejor que el otro.";
		        break;
		    }
		    case ($abs_estado >=1 && $abs_estado <=3):{ //[1,2,3] Diferencia leve
		        $cronica_estado = " El partido esta prácticamente igualado. ".$equipo_ganando." es ligeramente mejor que ".$equipo_perdiendo.".";
		        break;
		    }
		    case ($abs_estado >=4 && $abs_estado <=6):{ //[4,5,6] Diferencia normal
				$cronica_estado = " El equipo ".$equipo_ganando." es notablemente superior a ".$equipo_perdiendo.".";
		        break;
		    }
		    case ($abs_estado >=7 && $abs_estado <=9):{ //[7,8,9] Muy favorable
				$cronica_estado = " El partido está siendo dominado por ".$equipo_ganando.". ".$equipo_perdiendo." tiene que ponerse las pilas.";
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
		    	$cronica_dif_estado = " El partido sigue igual que antes. Nada ha cambiado. Esta muy reñido.";
		        break;
		    }
		    case ($dif_estado >=1 && $dif_estado <=3):{ //[1,2,3] Diferencia leve
				$cronica_dif_estado = " El equipo ".$equipo_mejorado." ha mejorado su posicion ligeramente.";
		        break;
		    }
		    case ($dif_estado >=4 && $dif_estado <=6):{ //[4,5,6] Diferencia ligera
				$cronica_dif_estado = " La táctica de juego ha cambiado y el equipo ".$equipo_mejorado." ha mejorado su posición.";
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

		$cronica_descanso = "";
		if ($this->turno == self::TURNO_DESCANSO-1)
		{
			$cronica_descanso = "\nDescanso: Comienza el descanso y ambos equipos se van a los vestuarios. Es hora de tomar un descanso y esperar a ver qué nos depara la segunda mitad de juego.\n";
		}

		//TODO comentar la diferencia de goles

		
		$this->cronica = $cronica_descanso."\n".$cronica_turno.$cronica_gol.$cronica_estado.$cronica_dif_estado."\n".$this->cronica;
		//$this->cronica .= "Estado Antiguo".$estado_antiguo."/Estado Actual".$this->estado;
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
        if ($local === null)
            throw new Exception('Equipo local inexistente.',404);
        if ($visitante === null)
            throw new Exception('Partido inexistente.',404);
		$this->cronica .= "\nInicio del partido: Comienza el encuentro entre los ".$local->nombre." como locales y los ".$visitante->nombre." en posición de visitantes. ";
		$this->cronica .= ($this->aforo_local > 2*$this->aforo_visitante) ? "Por lo visto no ha habido demasiados desplazamientos en el equipo visitante. El estadio se llena con los colores de los ".$local->nombre.". " : "";  
		$this->cronica .= ($this->ambiente > self::AMBIENTE_MEDIO) ? "El ambiente está caldeado y la afición espera con ganas ver a su equipo en acción. " : 
		"Los ánimos brillan por su ausencia. Ambas aficiones parecen estar apagadas. Parece que no se jueguen mucho en este encuentro. "; 
		$this->cronica .= ($this->estado > 0) ? "El equipo local empieza con superioridad, esperemos que aguanten así todo el partido." : 
		"El equipo visitante empieza con superioridad, esperemos que aguanten así todo el partido. ";  
		$this->cronica .="\n";
	}

	/*
	 * 1. Da una bonificacion por el encuentro
	 * 2. Desactiva las entradas compradas por los usuarios -> DE MOMENTO OLVIDARLO
	 * 3. Actualizar clasificación
	 * 4. Mover turno para finalizar encuentro.
	 */
	private function finalizaEncuentro()
	{
		$this->generaBonificacion();
		$this->actualizaClasificacion();
		//$this->turno++;
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
		try
		{
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
		}
		catch(Exception $exc)
		{
			throw new Exception("Error al generar la bonificacion al animo de final de partido", 1);
		}
	}

	/*
	 * Recalcula los puntos y actualiza la clasificación.
	 */
	private function actualizaClasificacion()
	{			
		try
		{
			$local=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=> $this->id_local));
			$visit=Clasificacion::model()->findByAttributes(array('equipos_id_equipo'=> $this->id_visitante));

			//Miro quien ha ganado el partido 
			//Sumo los puntos y los goles a favor y en contra de cada equipo
			if($this->goles_local>$this->goles_visitante)
			{
				$puntosLocal=$local->puntos;
				$puntosLocal=$puntosLocal+3;
				$ganadosLocal=$local->ganados;
				$perdidosVisit=$visit->perdidos;
				$local->setAttributes(array('puntos'=>$puntosLocal));
				$local->setAttributes(array('ganados'=>$ganadosLocal+1));
				$visit->setAttributes(array('perdidos'=>$perdidosVisit+1));       
			}else if($this->goles_local<$this->goles_visitante)
					{
						$puntosVisitante=$visit->puntos;
						$puntosVisitante=$puntosVisitante+3;
						$ganadosVisit=$visit->ganados;
						$perdidosLocal=$local->perdidos;
						$local->setAttributes(array('perdidos'=>$perdidosLocal+1));
						$visit->setAttributes(array('ganados'=>$ganadosVisit+1));
						$visit->setAttributes(array('puntos'=>$puntosVisitante)); 
					}else 
						{
							$puntosLocal=$local->puntos;
							$puntosLocal=$puntosLocal+1;							
							$puntosVisitante=$visit->puntos;
							$puntosVisitante=$puntosVisitante+1;
							$empatadosVisit=$visit->empatados;
							$empatadosLocal=$local->empatados;
							$local->setAttributes(array('empatados'=>$empatadosLocal+1));
							$visit->setAttributes(array('empatados'=>$empatadosVisit+1));
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
	
		}
		catch(Exception $exc)
		{		
			throw new Exception("Error al recalcular la clasificación", 1);
		}

	}
	
	/*
	* Esta función genera una breve crónica para el descanso del encuentro.
	*/
	private function generaCronicaDescanso()
	{
		$cronicaDesc="";
		$cronicaDesc .= "\nSegunda parte: Finaliza el descanso y ambos equipos vuelven al terreno de juego. El partido se reanuda.";
		//Indicar fin del descanso y reanudación del partido
		$cronicaDesc .= ($this->estado > 0) ? " El equipo local continua el juego con superioridad, esperemos que aguanten así el resto de la segunda parte." : 
		" El equipo visitante continua el juego con superioridad, esperemos que aguanten así el resto de la segunda parte. "; 

		$this->cronica=$cronicaDesc."\n".$this->cronica;
	}

	/*
	* Genera una crónica para el último turno de partido (fin de partido)
	*/
	private function generaCronicaUltimoTurno()
	{
		//Tomar fijos datos locales y visitantes
		$local = Equipos::model()->findByPk($this->id_local);
        $visitante = Equipos::model()->findByPk($this->id_visitante);  
        //Comprobación de existencia de datos por seguridad
        if ($local === null)
            throw new Exception('Equipo local inexistente.',404);
        if ($visitante === null)
            throw new Exception('Partido inexistente.',404);

         //Inicializar variable $cronAux
		$cronAux = "Fin del partido: Finaliza el encuentro entre los ".$local->nombre." y los ".$visitante->nombre." con un marcador final de ".$this->goles_local." a ".$this->goles_visitante.". ";
		
        //Generar crónica final
        if ($this->goles_local > $this->goles_visitante)
        {
        	//Ganador local
        	$cronAux .= "Clara victoria para los locales, que ganan puntos adicionales en la clasificación.";
        }
        else 
        {
        	if ($this->goles_local < $this->goles_visitante)
        	{
        		//Ganador visitante
        		$cronAux .= "Clara victoria para los visitantes, que ganan puntos adicionales en la clasificación.";
        	}
        	else
        	{
        		//Empate
        		$cronAux .= "Por el empate, ambos equipos suman tan sólo un punto más en la clasificación.";
        	}
        }
       

		$this->cronica = $cronAux."\n".$this->cronica;
	}

	/*
	* Genera el estado tras el descanso y aumenta el turno para continuar el encuentro
	*/
	private function generaEstadoDescanso()
	{
		//Generamos estado tras el descanso		
        $params = array(
 			'difNiv'    => (double) $this->dif_niveles, 'aforoMax'  => (double) 0,
 			'aforoLoc'  => (double) $this->aforo_local, 'aforoVis'  => (double) $this->aforo_visitante,
			'moralLoc'  => (double) $this->moral_local, 'moralVis'  => (double) $this->moral_visitante,
			'ofensLoc'  => (double) $this->ofensivo_local, 'ofensVis'  => (double) $this->ofensivo_visitante,
			'defensLoc' => (double) $this->defensivo_local, 'defensVis' => (double) $this->defensivo_visitante,
			'estado'    => null
		);

		$this->estado = Formula::siguienteEstado($params);

		//Aumentamos el turno
		$this->turno++;
	}

	/*
	* Esta función calcula el siguiente partido de un equipo dado y lo asigna a dicho
	* equipo. En caso de que no haya más partidos, colocará un NULL en la fila correspondiente
	* de la tabla Equipos.
	*/
	private function actualizaSiguientePartido($id_equipo)
	{
		//Tomar hora actual
		$tiempo=time();

		$primerTurno=Partido::PRIMER_TURNO;

		//Generar criterio de búsqueda para conocer el siguiente encuentro
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo <= hora');
		$busqueda->addCondition('turno = :bPrimerTurno');
		$busqueda->addCondition('((equipos_id_equipo_1 = :bequipo) OR (equipos_id_equipo_2 = :bequipo))');
		$busqueda->params = array(':bTiempo' => $tiempo,
								':bPrimerTurno' => $primerTurno,
								':bequipo' => $id_equipo
								);
		$busqueda->order = 'hora ASC';

		//Buscamos el siguiente partido
		$partidos=Partidos::model()->find($busqueda);

		$equipo = Equipos::model()->findByPk($id_equipo);
		if ($equipo === null)
			throw new Exception("El equipo no existe (Partido.php).", 404);
			
		if ($partidos === null)
		{
			//Si no hay más partidos que jugar esta temporada, el siguiente será NULL
			$equipo->partidos_id_partido = null;
		}
		else
		{
			//Asignamos el siguiente partido
			$equipo->partidos_id_partido = $partidos->id_partido;
		}

		//Guardamos los datos
		if (!$equipo->save())
			throw new Exception("Error al situar proximo partido.", 404);						
	}

	/*
	* Esta función rellena los datos (aforo base, nivel de equipo, etc.) del siguiente encuentro
	* de un equipo a partir de los datos almacenados en la fila correspondiente de la tabla
	* Equipos.
	*/
	private function rellenaSiguientePartido($id_equipo)
	{
		//Tomar datos del equipo
		$equipo = Equipos::model()->findByPk($id_equipo);

		//Tomar datos del siguiente partido
		$sigPartido = $equipo->sigPartido;

		//Si sigPartido === null, entonces no existe siguiente partido. Se corresponde, por
		//ejemplo, al estado tras el último partido de temporada.
		if ($sigPartido !== null)
		{
			//Comprobamos si el equipo será local o visitante y asignamos
			//los datos iniciales de dicho encuentro.
			if ($sigPartido->equipos_id_equipo_1 === $id_equipo)
			{
				//Caso local
				$sigPartido->nivel_local = $equipo->nivel_equipo;
				$sigPartido->ofensivo_local = $equipo->factor_ofensivo;
				$sigPartido->defensivo_local = $equipo->factor_defensivo;
				$sigPartido->aforo_local = $equipo->aforo_base;
			}
			else
			{
				if ($sigPartido->equipos_id_equipo_2 === $id_equipo)
				{
					//Caso visitante
					$sigPartido->nivel_visitante = $equipo->nivel_equipo;
					$sigPartido->ofensivo_visitante = $equipo->factor_ofensivo;
					$sigPartido->defensivo_visitante = $equipo->factor_defensivo;
					$sigPartido->aforo_visitante = $equipo->aforo_base;
				}
				else
				{
					throw new Exception(404, "No se juega como local ni visitante en ese partido. (rellenaSiguientePartido,Partido.php)");
					
				}
			}

			//Guardar datos del partido
			if (!$sigPartido->save())
			{
				throw new Exception(404, "No se ha podido guardar el estado del partido. (rellenaSiguientePartido,Partido.php)");
				
			}
		}
	}

	/*
	* Esta función elimina las acciones grupales finalizadas asociadas al equipo.
	*/
	public function eliminaGrupales($id_equipo)
	{
		$grupales = AccionesGrupales::model()->findAllByAttributes(array('equipos_id_equipo'=> $id_equipo,'completada'=> 1));	
		foreach ($grupales as $gp)
		{		
			Participaciones::model()->deleteAllByAttributes(array('acciones_grupales_id_accion_grupal'=> $gp->id_accion_grupal));
			AccionesGrupales::model()->deleteByPk($gp->id_accion_grupal);
		}
	}

	/*
	* Esta función ejecuta un turno completo del partido cargado en la constructora
	*/
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
		    	$this->generaEstadoDescanso();
		    	$this->generaCronicaDescanso();
		    	$this->guardaEstado();
		    	break;
		    case (($this->turno > self::PRIMER_TURNO) 
		    	&& ($this->turno < self::ULTIMO_TURNO/*-1*/) 
		    	&& ($this->turno != self::TURNO_DESCANSO)):	
		    	//Este apartado incluye el descanso del partido!
		    	//Turnos de partido
				$this->generar_estado();
				$this->guardaEstado();
		        break;
		    case self::ULTIMO_TURNO/*-1*/:
		    	//Turno para generar el estado y crónica finales
				$this->generar_estado();
				$this->generaCronicaUltimoTurno();
				/****/
				$this->finalizaEncuentro();
				/****/
				$this->guardaEstado();
				/****/
				$this->actualizaSiguientePartido($this->id_local);
				$this->actualizaSiguientePartido($this->id_visitante);
				$this->rellenaSiguientePartido($this->id_local);
				$this->rellenaSiguientePartido($this->id_visitante);
				$this->eliminaGrupales($this->id_local);
				$this->eliminaGrupales($this->id_visitante);
				//Creamos una notificación de fin de partido
				$notificacion = new Notificaciones;
				$notificacion->fecha = time();
				$notificacion->mensaje = Equipos::model()->findByPk($this->id_local)->nombre . " ".$this->goles_local . " - " .$this->goles_visitante." ".Equipos::model()->findByPk($this->id_visitante)->nombre;
				$notificacion->imagen = "images/iconos/notificaciones/partido_terminado.png";
				$notificacion->save();
				//Enviamos la notificación a los interesados
				$componentes = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$this->id_local));
				foreach ($componentes as $componente){
					$usrnotif = new Usrnotif;
					$usrnotif->notificaciones_id_notificacion = $notificacion->id_notificacion;
					$usrnotif->usuarios_id_usuario = $componente->id_usuario;
					$usrnotif->save();

					//Devuelvo la influencia a los participantes7
					$componente->recursos->influencias_partido_bloqueadas = 0;
					$componente->recursos->save();
				}
				$componentes = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$this->id_visitante));
				foreach ($componentes as $componente){
					$usrnotif = new Usrnotif;
					$usrnotif->notificaciones_id_notificacion = $notificacion->id_notificacion;
					$usrnotif->usuarios_id_usuario = $componente->id_usuario;
					$usrnotif->save();

					//Devuelvo la influencia a los participantes
					$componente->recursos->influencias_partido_bloqueadas = 0;
					$componente->recursos->save();
				}
				/****/
		    	break;
		    /*case self::ULTIMO_TURNO:
		    	//Turno para permitir visualizar el fin de partido durante un tiempo extra
		    	//y cambiar los datos del siguiente partido
				$this->finalizaEncuentro();
				$this->guardaEstado();
				$this->actualizaSiguientePartido($this->id_local);
				$this->actualizaSiguientePartido($this->id_visitante);
				$this->rellenaSiguientePartido($this->id_local);
				$this->rellenaSiguientePartido($this->id_visitante);
				$this->eliminaGrupales($this->id_local);
				$this->eliminaGrupales($this->id_visitante);
				//Creamos una notificación de fin de partido
				$notificacion = new Notificaciones;
				$notificacion->fecha = time();
				$notificacion->mensaje = Equipos::model()->findByPk($this->id_local)->nombre . "(local)" . " vs " . Equipos::model()->findByPk($this->id_visitante)->nombre . "(visitante)";
				$notificacion->imagen = "images/iconos/notificaciones/partido_terminado.png";
				$notificacion->save();
				//Enviamos la notificación a los interesados
				$componentes = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$this->id_local));
				foreach ($componentes as $componente){
					$usrnotif = new Usrnotif;
					$usrnotif->notificaciones_id_notificacion = $notificacion->id_notificacion;
					$usrnotif->usuarios_id_usuario = $componente->id_usuario;
					$usrnotif->save();
				}
				$componentes = Usuarios::model()->findAllByAttributes(array('equipos_id_equipo'=>$this->id_visitante));
				foreach ($componentes as $componente){
					$usrnotif = new Usrnotif;
					$usrnotif->notificaciones_id_notificacion = $notificacion->id_notificacion;
					$usrnotif->usuarios_id_usuario = $componente->id_usuario;
					$usrnotif->save();
				}
		    	break;*/
		    default:
		       	// No debería llegar aquí
		    	echo "Jodimos algo";
		}
	}
}
