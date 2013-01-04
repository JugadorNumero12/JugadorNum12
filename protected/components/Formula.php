<?php

public class Formula
{
	private $estado;
 	private	$dif_niveles;
 	private $aforo_local;
	private $aforo_visitante;
	private $moral_local;
	private $moral_visitante;
	private $ofensivo_local;
	private $ofensivo_visitante;
	private $defensivo_local;
	private $defensivo_visitante;

	/** Constructora */
	public Formula ( $estado, $dif_niveles, $aforo_local ,$aforo_visitante,
					 $moral_local ,$moral_visitante ,$ofensivo_local ,$ofensivo_visitante,
					 $defensivo_local ,$defensivo_visitante )
	{
		$this->$estado = $estado;
 		$this->$dif_niveles = $dif_niveles;
 		$this->$aforo_local = $aforo_local;
		$this->$aforo_visitante = $aforo_visitante;
		$this->$moral_local = $moral_local;
		$this->$moral_visitante = $moral_visitante;
		$this->$ofensivo_local = $ofensivo_local;
		$this->$ofensivo_visitante = $ofensivo_visitante;
		$this->$defensivo_local  = $defensivo_local;
		$this->$defensivo_visitante = $defensivo_visitante;
	}
		
	/** Formula del juego */
	public int siguiente_estado()
	{
		/* DANI & PEDRO */
		// No quiero ver una linea de codigo hasta que este probada en MatLab o simulador similar
	}
}