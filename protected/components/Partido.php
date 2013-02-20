<?php
/**
*
* CLASE PARA EL PARTIDO
*
*/
public class Partido
{
	/* Un partido se juega entre los turnos 1 - 10 
	* El turno 0 es inicialización de partido.
	* El turno 6 es de descanso del partido.
	*/
	const PRIMER_TURNO = 0;
	const ULTIMO_TURNO = 11;
	const TURNO_DESCANSO = 6;

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
            $this->$id_partido = $id_partido;
            $this->$id_local = $partido->equipos_id_equipo_1;
            $this->$id_visitante = $partido->equipos_id_equipo_2;
            $this->$turno = $partido->turno;
            $this->$cronica = $partido->cronica;
            $this->$ambiente = $partido->ambiente;
            $this->$dif_niveles = $partido->dif_niveles;
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
    private function guardaEstado()
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
	private function inicializaEncuentro()
	{
		//Fijar turno inicial
		$this->turno = 1;
		//Fijar goles iniciales por seguridad
		$this->goles_local = 0;
		$this->goles_visitante = 0;
		//Generamos estado inicial del partido
		$this->estado = Formula::siguienteEstado(/*PARAMS*/);
		//Tomar fijos datos locales y visitantes
		$local = Equipos::model()->findByPk($this->id_local);
        $visitante = Equipos::model()->findByPk($this->id_visitante);
        //Comprobación de existencia de equipos por seguridad
        if ($local == null)
            throw new CHttpException(404,'Equipo local inexistente.');
        if ($visitante == null)
            throw new CHttpException(404,'Equipo visitante inexistente.');
        //Fijar diferencia de niveles
        /*
        *
        * Acciones grupales ejecutadas mediante script o 
        * recopiladas todas las finalizadas antes de un partido.
        * En caso de ser recopiladas hay que tomar la dif. niveles de
        * la tabla de Partido y en caso de ser ejecutadas por script
        * tomadas de la tabla correspondiente del equipo local o visitante.
		*
		* En caso de ser por script, revisar campos de aforo en Equipos!!!!
        *
        *
        */
        $this->dif_niveles = $local->nivel_equipo - $visitante->nivel_equipo;
        //Fijar aforos local y visitante


        //TODO


        //Fijar factores ofensivo y defensivo
        $this->ofensivo_local = $local->factor_ofensivo;
        $this->defensivo_local = $local->factor_defensivo;
        $this->ofensivo_visitante = $visitante->factor_ofensivo;
        $this->defensivo_visitante = $visitante->factor_defensivo;
        //Moral inicial
        $this->moral_local = 0;
        $this->moral_visitante = 0;

        //Ambiente ya tomado en la constructora
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

		$estado = Formula::siguienteEstado(array('estado'=>$estado, 'difNiv'=>$dif_niveles, 
											'moralLoc'=>$moral_local ,'moralVis'=>$moral_visitante));

		if($estado == null){
			throw new CHttpException(404,'Error en la formula. No se ha calculado bien el siguiente estado');
		}

		
		switch ($estado) {
		    case 10: { //Gol del equipo local
		        $this->$goles_local = $this->$goles_local+1;
		        //TODO llamada a la fórmula para volver a equilibrar el partido (var $estado)
		        break;
		    }
		    case -10:{ //Gol del equipo visitante
		        $this->$goles_visitante = $this->$goles_visitante+1;
		        //TODO llamada a la fórmula para volver a equilibrar el partido (var $estado)
		        break;
		    }
		    //Default: No ha habido gol, por tanto $this->$estado se queda igual

		}

		self::generaCronicaTurno();

		//Si estamos en el descanso del partido. Nivelamos el $estado del partido
		if($this->$turno == 5){
			//TODO llamada a la fórmula para volver a equilibrar el partido (var $estado)
		}

		//Aumentamos turno
		$this->$turno = $this->$turno+1;

		
	}

	/*
	 * Genera la crónica para este turno en función de la crónica acumulada en la BBDD y 
	 * la guarda en la variable $cronica
	 */
	private function generaCronicaTurno()
	{
		/* MARCOS */
		/*
		*
		* rehacer, no guarda la crónica en la bbdd
		*/

		/*$trans = Yii::app()->db->beginTransaction();
		try{
			$partido=Partidos::model()->findByPk($id_partido);
			$partido['cronica'] += $cronica;
			$partido->save();
			$trans->commit();
		}catch(Exception $exc){
			$trans->roollback();
			throw new Exception("Error al guardar la cronica", 1);
		}*/
	}

	/*
	 * Genera una crónica inicial para el partido.
	 */
	private function generaCronicaBase()
	{
		
	}

	/*
	 * 1. Da una bonificacion por el encuentro
	 * 2. Desactiva las entradas compradas por los usuarios -> DE MOMENTO OLVIDARLO
	 * 3. Actualizar clasificación
	 */
	private function finalizaEncuentro()
	{
		generaBonificacion();
		actualizaClasificacion();
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
	private function bonifAnimo($equipo, int $bonus)
	{
		/*$bonifParticipante = 3;
		  $bonifNoParticipante = 1*/
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
				$rec['animo']= min(round(3*$bonusAmbiente+$rec['animo']), $rec['animo_max']);
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
	private function actualizaClasificacion()
	{			
		$trans = Yii::app()->db->beginTransaction();
		try{
			$local=Clasificacion::model()->find(array('equipos_id_equipo'=> $id_local));
			$visit=Clasificacion::model()->find(array('equipos_id_equipo'=> $id_visitante));

			//Miro quien ha ganado el partido 
			//Sumo los puntos y los goles a favor y en contra de cada equipo
			if($goles_local>$goles_visitante)
			{
				$puntosLocal=$local->puntos;
				$puntosLocal=$puntosLocal+3;
				$local->setAttributes(array('puntos'=>$puntosLocal));         
			}else if($goles_local<$goles_visitante)
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
			$difPartidoLocal=$goles_local-$goles_visitante;
			$difPartidoVisit=$goles_visitante-$goles_local;
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
			$criteria->order = 'puntos ASC, diferencia_goles DESC';

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

	}

	private function generaEstadoDescanso()
	{

	}

	public function jugarse()
	{
		switch ($turno) 
		{
		    case PRIMER_TURNO:	
		    	//Turno inicial (preparar partido)		
		    	inicializaEncuentro();  
		    	generaCronicaBase();
		    	guardaEstado();      
		        break;
		    case TURNO_DESCANSO:
		    	//TODO Revisar!!!
		    	generaEstadoDescanso();
		    	generaCronicaDescanso();
		    	guardaEstado();
		    	break;
		    case (($turno > PRIMER_TURNO) && ($turno < ULTIMO_TURNO) && ($turno != TURNO_DESCANSO)):	
		    	//Este apartado incluye el descanso del partido!
		    	//Turnos de partido
				generar_estado();
				guardaEstado();
		        break;
		    case ULTIMO_TURNO:
		    	//Turno final, la diferencia es que ya no ofrecemos el extra de recursos
		    	//sino que ofrecemos la bonificacion por asistir/ganar.
				generar_estado();
				finalizaEncuentro();
				guardaEstado();
		    	break;
		    default:
		       	// No debería llegar aquí
		    	echo "Jodimos algo";
		}
	}
}
