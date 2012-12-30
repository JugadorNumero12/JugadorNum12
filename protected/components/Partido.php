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
	
	private $goles_local;
	private $goles_visitante;
	private $estado;
	private $moral_local;
	private $moral_visitante;
	private $ofensivo_local;
	private $ofensivo_visitante;
	private $defensivo_local;
	private $defensivo_visitante;

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
	 * las variables ambiente, aforos, y diferencia de niveles
	 * y lo almacena en la tabla turnos.
	 * A partir de la diferencia de niveles, almacena el primer estado
	 * del partido.
	 */
	private void inicializaEncuentro()
	{
		/* ALEX */
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
