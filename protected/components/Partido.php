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

            $local = Equipos::model()->findByPk($partido->$equipos_id_equipo_1);
            $visitante = Equipos::model()->findByPk($partido->$equipos_id_equipo_2);

            if ($local == null)
                throw new CHttpException(404,'Equipo local inexistente.');
            if ($visitante == null)
                throw new CHttpException(404,'Equipo visitante inexistente.');

            $this->$id_partido = $id_partido;
            $this->$id_local = $partido->$equipos_id_equipo_1;
            $this->$id_visitante = $partido->$equipos_id_equipo_2;
            $this->$turno = 0;
            $this->$cronica = $partido->$cronica;
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
            $estado = 0;
            $moral_local = 0;
            $moral_visitante = 0;
            
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
    private void cargaEstado()
    {
        /* ALEX */
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
    }
    
    /*
     * Guarda toda la información del estado actual en la base de datos.
     */
    private void guardaEstado()
    {
        /* ALEX */
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $turn = Turnos::findByPk($id_partido);

            if ($turn == null)
                throw new CHttpException(404,'Turno inexistente.');

            $turn->$ofensivo_local = $ofensivo_local;
            $turn->$ofensivo_visitante = $ofensivo_visitante;
            $turn->$defensivo_local = $defensivo_local;
            $turn->$defensivo_visitante = $defensivo_visitante;

            $turn->goles_local = $goles_local;
            $turn->$goles_visitante = $goles_visitante;
            $turn->estado = $estado;
            $turn->$moral_local = $moral_local;
            $turn->$moral_visitante = $moral_visitante;
            if(!$turno->save()) 
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

            generar_estado(); //se supone que cambia la variable $estado pero dudo que lo haga
            //revisar cuando acaben la fórmula
			/*y lo almacena en la tabla turnos.
			/*A partir de la diferencia de niveles, almacena el primer estado del partido.*/
			guardaEstado();
		}catch(Exception $e){
			$transaction->rollback();
			throw $e;
		}
	}

	/*
	 * En función de los datos recogidos para este turno y el estado anterior,
	 * pasa al estado siguiente llamando a un objeto Formula
	 */
	private void generar_estado()
	{	
		/*$foo = new Formula(	$estado, $dif_niveles, $aforo_local ,$aforo_visitante,
							$moral_local ,$moral_visitante ,$ofensivo_local ,$ofensivo_visitante,
							$defensivo_local ,$defensivo_visitante );
		$estado = $foo->siguiente_estado();*/
		//completar con los nombres que se usen en la Formula
		$estado = Formula::siguienteEstado(array($estado, $dif_niveles, $aforo_local ,$aforo_visitante,
							$moral_local ,$moral_visitante ,$ofensivo_local ,$ofensivo_visitante,
							$defensivo_local ,$defensivo_visitante ));
	}

	/*
	 * Genera la crónica para este turno en función de la crónica acumulada en la BBDD y 
	 * la guarda en la variable $cronica y en la BBDD
	 */
	private void generaCronicaTurno()
	{
		/* MARCOS */
		$trans = Yii::app()->db->beginTransaction();
		try{
			$partido=Partidos::model()->findByPk($id_partido);
			$partido['cronica'] += $cronica;
			$partido->save();
			$trans->commit();
		}catch(Exception $exc){
			$trans->roollback();
			throw new Exception("Error al guardar la cronica", 1);
		}
	}

	/*
	 * Genera una crónica inicial para el partido.
	 */
	private void generaCronicaBase()
	{
		/* PEDRO */
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
		/* MARCOS */
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

		if(!($transaction instaceof CDbTransaction && $transaction->getActive())
		//FIXME comprobar que Yii no jode el funcionamiento del instanceof de PHP
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
		    	cargaEstado();
				//recogeAccionesTurno();
				generar_estado();
				generaCronicaTurno();
				guardaEstado();
		        break;
		    case ULTIMO_TURNO:
		    	//Turno final, la diferencia es que ya no ofrecemos el extra de recursos
		    	//sino que ofrecemos la bonificacion por asistir/ganar.
		    	cargaEstado();
				//recogeAccionesTurno();
				generar_estado();
				generaCronicaTurno();
				finalizaEncuentro();
				guardaEstado();
		    	break;
		    default:
		       	// No debería llegar aquí
		    	echo "Jodimos algo";
		}
	}
}
