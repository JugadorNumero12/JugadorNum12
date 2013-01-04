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
	private /*static*/ $lista_atributos = array(
		'local' => /*static*/ array(
			'id'=> $id_local,
			'aforo'=> $aforo_local,
			'ofensivo'=> $ofensivo_local,
			'defensivo'=> $defensivo_local,
			'goles'=> $goles_local,
			'moral'=> $moral_local
		),
		'visitante' => /*static*/ array(
			'id'=> $id_visitante,
			'aforo'=> $aforo_visitante,
			'ofensivo'=> $ofensivo_visitante,
			'defensivo'=> $defensivo_visitante,
			'goles'=> $goles_visitante,
			'moral'=> $moral_visitante
		),
		//FIXME comprovar que => asigna por referencia
	);

	/**
	 * Constructora: Inicializar 
	 * 	id_partido,
	 * 	local, visitante, turno cronica
	 *  ambiente, dif_niveles, aforo_local, aforo_visitante
	 * a partir del id_partido de la tabla de partidos
	 */
	public Partido($id_partido)
	{
		/* ALEX */
	}

	/**
 	 * Funcion que inicializa los atributos 
 	 *	estado, moral, ofensivo, defensivo y goles
 	 * cargandolos desde la tabla turnos 
 	 */
	private void cargaEstado()
	{
		/* ALEX */
	}
	
	/*
	 * Guarda toda la información del estado actual en la base de datos.
	 */
	private void guardaEstado()
	{
		/* ALEX */
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
	}

	/*
	 * Recoge los datos de las acciones de este turno de locales y visitantes y recalcula los factores.
	 * También, de forma transaccional todo, modifica el turno actual en la tabla Partidos (hay que añadirlo)
	 * para que las acciones sepan a qué turno tienen que ser asociadas.
	 * Importante -> esto provoca que ejecutar una accion de partido sea una transacción también.
	 */
	private void recogeAccionesTurno()
	{
		/* MARCOS */

		//No tengo id_accion, no puedo ejecutarla con su metodo

		$trans = Yii::app()->db->beginTransaction();
		try{
			//consultar en accionesturno con la id de partido y el turno, las acciones realizadas
			$acciones = AccionesTurno::model()->findAllByAtributes(array(partidos_id_partido=>$id_partido, turno=>$turno));
			$tablaTurno = Turno::model()->findByAttributes(array(partidos_id_partido=>$id_partido, turno=>$turno));
			foreach ($acciones as $acc) {
				$id_habilidad = $acc('habilidades_id_habilidad')
				$cod = Habilidades::model()->findByPk($id_habilidad);
				if($cod == null){
					$log=fopen("runtime/application.log","a");
					fwrite($log, "Run time error: Habilidades::codigo of habilidad ".$id_habilidad." not found. [turno ".$turno."| partido ".$id_partido."]\n");
					fclose($log);
					break;//si la habilidad no existe me la salto.
				}
				$id_equipo = $acc('equipos_id_equipo')
				switch ($id_equipo) {
					case $id_local:
						$accLocal = true;
						break;
					case $id_visitante:
						$accLocal = false;
						break;
					default:
						$accLocal = null;
				}
				if(!isset($accLocal)){
					$log=fopen("runtime/application.log","a");
					fwrite($log, "Run time error: encontrada una accion del equipo ".$id_equipo.". [turno ".$turno."| partido ".$id_partido."]\n");
					fclose($log);
					break;//si se ha colado una acción de un equipo que no participa la salto.
				}

				$lista_de_equipo = $lista_atributos[($accLocal?'local':'visistante')]

				//consultar el efecto de las acciones en components/Acciones/tabla_efectos.php::datos_acciones

				foreach (array_keys($datos_acciones['cod']) as $atributo) 
					if( array_key_exists($atributo, $lista_de_equipo) ){
						//sumo porque no se que operador se aplica (no viene en ningun sitio)
						$lista_de_equipo[$atributo] += $datos_acciones['cod'][$atributo];
					
						//actualizar la tabla
						$tablaTurno[$atributo.($accLocal?'_local':'_visistante')] = $lista_de_equipo[$atributo];
					}

			}
			//Partido['turno']=++$turno;

			$tablaTurno->save();

			$trans->commit();

		}catch(Exception $exc) {
    		$trans->rollback();
    		throw $exc;
		}
	}
	
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
		/* MARCOS */
	}

	/*
	 * Recalcula los puntos y actualiza la clasificación.
	 */
	private void actualizaClasificacion()
	{
		/* MARCOS */
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
