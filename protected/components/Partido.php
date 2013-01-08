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

	//atributo redundante añadido para hacer busquedas automaticas
	/*private $lista_atributos = array(
		'local' => array(
			'id'=> $id_local,
			'aforo'=> $aforo_local,
			'ofensivo'=> $ofensivo_local,
			'defensivo'=> $defensivo_local,
			'goles'=> $goles_local,
			'moral'=> $moral_local
		),
		'visitante' => array(
			'id'=> $id_visitante,
			'aforo'=> $aforo_visitante,
			'ofensivo'=> $ofensivo_visitante,
			'defensivo'=> $defensivo_visitante,
			'goles'=> $goles_visitante,
			'moral'=> $moral_visitante
			//FIXME comprovar que => asigna por referencia
		),*/

	/**
	 * Constructora: Inicializar 
	 * 	id_partido,
	 * 	local, visitante, turno cronica
	 *  ambiente, dif_niveles, aforo_local, aforo_visitante
	 * a partir del id_partido de la tabla de partidos
	 */
	public Partido($id_partido)
	{
		/* ALEX */ //poner bonito 
        $transaction = Yii::app()->db->beginTransaction();
        try{
        	$partido = Partidos::model()->findByPk($id_partido);
        	if ($partido != null){
        		//$local = Equipos::model()->findByPk($partido->$equipos_id_equipo_1);
        		//$visitante = Equipos::model()->findByPk($partido->$equipos_id_equipo_2);

        		$this->$id_partido = $id_partido;
        		$this->$id_local = $partido->$equipos_id_equipo_1;
        		$this->$id_visitante = $partido->$equipos_id_equipo_2;
        		$this->$turno = 0;
        		$this->$cronica = $partido->$cronica;
        		$this->$ambiente = $partido->$ambiente;
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
        	}
        }catch(Exception $e){
        	$transaction->rollback();
        }
	}

	/**
 	 * Funcion que inicializa los atributos 
 	 *	estado, moral, ofensivo, defensivo y goles
 	 * cargandolos desde la tabla turnos 
 	 */
	private void cargaEstado()
	{
		/* ALEX */ //poner bonito
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$partido = Partidos::findByPk($id_partido);
			if($partido != null){
				$ofensivo_local = $turno->$ofensivo_local;
				$ofensivo_visitante = $turno->$ofensivo_visitante;
				$defensivo_local = $turno->$defensivo_local;
				$defensivo_visitante = $turno->$defensivo_visitante;

				$goles_local = $turno->goles_local;
				$goles_visitante = $turno->$goles_visitante;
				$estado = $turno->estado;
				$moral_local = $turno->$moral_local;
				$moral_visitante = $turno->$moral_visitante;
				$transaction->commit();
			}
		}catch(Exception $e){
			$transaction->rollback();
		}
	}
	
	/*
	 * Guarda toda la información del estado actual en la base de datos.
	 */
	private void guardaEstado()
	{
		/* ALEX */ //poner bonito + aumento turno?
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$partido = Partidos::findByPk($id_partido);
			if($partido != null){
				$turno->$ofensivo_local = $ofensivo_local;
				$turno->$ofensivo_visitante = $ofensivo_visitante;
				$turno->$defensivo_local = $defensivo_local;
				$turno->$defensivo_visitante = $defensivo_visitante;

				$turno->goles_local = $goles_local;
				$turno->$goles_visitante = $goles_visitante;
				$turno->estado = $estado;
				$turno->$moral_local = $moral_local;
				$turno->$moral_visitante = $moral_visitante;
				if($turno->save()){
					$transaction->commit();
				}
			}
		}catch(Exception $e){
			$transaction->rollback();
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

		}catch(Exception $e){
			$transaction->rollback();
		}
	}

	/*
	 * Recoge los datos de las acciones de este turno de locales y visitantes y recalcula los factores.
	 * También, de forma transaccional todo, modifica el turno actual en la tabla Partidos (hay que añadirlo)
	 * para que las acciones sepan a qué turno tienen que ser asociadas.
	 * Importante -> esto provoca que ejecutar una accion de partido sea una transacción también.
	 */
	/*private void recogeAccionesTurno()
	{
		// MARCOS
		$trans = Yii::app()->db->beginTransaction();
		try{
			//consultar las acciones guardadas para este turno
			$acciones = AccionesTurno::model()->findAllByAtributes(array(partidos_id_partido=>$id_partido, turno=>$turno));
			
			//abrir la tabla del turno para guardar los resultados
			$tablaTurno = Turno::model()->findByAttributes(array(partidos_id_partido=>$id_partido, turno=>$turno));
			
			//para cada accion ejecutada
			foreach ($acciones as $acc) {
				$id_habilidad = $acc('habilidades_id_habilidad')

				//busco el código (nombre de la habilidad)
				$cod = Habilidades::model()->findByPk($id_habilidad);
				if($cod == null){
					$log=fopen("runtime/application.log","a");
					fwrite($log, "Run time error: Habilidades::codigo of habilidad ".$id_habilidad." not found. [turno ".$turno."| partido ".$id_partido."]\n");
					fclose($log);
					break;//si la habilidad no existe me la salto.
				}

				//guardo en accLocal si la han ejecutado los locales o los visitantes
				$id_equipo = $acc('equipos_id_equipo')
				if($id_equipo == $id_local) $accLocal = true;
				elseif($id_equipo == $id_visitante) $accLocal = false;
				else{
					$log=fopen("runtime/application.log","a");
					fwrite($log, "Run time error: encontrada una accion del equipo ".$id_equipo.". [turno ".$turno."| partido ".$id_partido."]\n");
					fclose($log);
					break;//si se ha colado una acción de un equipo que no participa la salto.
				}

				//busco los artibutos del equipo correspondiente
				$lista_de_equipo = $lista_atributos[($accLocal?'local':'visistante')]

				//compruebo las keys de datos_acciones y actualizo las que corresponden a mis atributos
				foreach (array_keys($datos_acciones['cod']) as $atributo) 
					if( array_key_exists($atributo, $lista_de_equipo) ){
						//sumo porque no se que operador se aplica
						$lista_de_equipo[$atributo] += $datos_acciones['cod'][$atributo];
					
						//actualizar la tabla
						$tablaTurno[$atributo.($accLocal?'_local':'_visistante')] = $lista_de_equipo[$atributo];
					}

			}
			//salvo los cambios de todas las acciones
			$tablaTurno->save();

			$trans->commit();

		}catch(Exception $exc) {
    		$trans->rollback();
    		throw $exc;
		}
	}*/
	
	/*
	 * En función de los datos recogidos para este turno y el estado anterior,
	 * pasa al estado siguiente llamando a un objeto Formula
	 */
	private void generar_estado()
	{
		$foo = new Formula(	$estado, $dif_niveles, $aforo_local ,$aforo_visitante,
							$moral_local ,$moral_visitante ,$ofensivo_local ,$ofensivo_visitante,
							$defensivo_local ,$defensivo_visitante );
		$estado = $foo->siguiente_estado();
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
		/* MARCOS 
		$bonifGanador = 28;
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
	private void bonifAnimo($equipo, $participantes, int $bonus){
		/*
		$bonifParticipante = 3;
		$bonifNoParticipante = 1*/
		$trans = Yii::app()->db->beginTransaction();
		try{
			$participantes=AccionesTurno::model()->findByAllAttributes(equipos_id_equipo=>$equipo, partidos_id_partido=>$id_partido),
			$usuarios=Usuarios::model()->findAllByAtributes(equipos_id_equipo=>$equipo);
			$bonusAmbiente = formulaDelAmbiente()*$bonus;
			foreach ($usuarios as $user){
				$rec=Recursos::model()->findByAttributes(usuarios_id_usuario=>$user);
				if(array_key_exists($user, $participantes))//FIXME a saber si esto funciona
					$rec['animo']= min(3*$bonusAmbiente+$rec['animo'], rec['animo_max']);
				else
					$rec['animo']= min(  $bonusAmbiente+$rec['animo'], rec['animo_max']);
				$rec->save();
			}
			$trans->commit();
		}catch(Exception $exc){
			$trans->roollback();
			throw $exc;
		}
	}
	private double formulaDelAmbiente(){
		//(1.5^(x+1))/(4+.7*x) donde x=ambiente
		return pow(1.5, $ambiente+1)/(4+.7*$ambiente);

	}

	/*
	 * Recalcula los puntos y actualiza la clasificación.
	 */
	private void actualizaClasificacion() //TODO
	{
		/* MARCOS */ 
		if($goles_local>$goles_visitante);
		elseif($goles_visitante>$goles_local);
		else;
		/*clasificacion +3gana , +1 empata, reordena clasif*/
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
				recogeAccionesTurno();
				generar_estado();
				generaCronicaTurno();
				guardaEstado();
		        break;
		    case ULTIMO_TURNO:
		    	//Turno final, la diferencia es que ya no ofrecemos el extra de recursos
		    	//sino que ofrecemos la bonificacion por asistir/ganar.
		    	cargaEstado();
				recogeAccionesTurno();
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
