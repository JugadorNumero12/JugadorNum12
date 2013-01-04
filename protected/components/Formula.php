<?php

class Formula
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
	public function __construct ( $estado, $dif_niveles, $aforo_local ,$aforo_visitante,
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

	public static function gauss ( $x, $avg, $stdev ) {
		return $x/10;
	}

	public static function probabilidades ( $actual ) {
		$probs = array();
		for ( $i=-10; $i<=10; $i++ ) {
			$probs[$i] = self::gauss( $i, $actual, 1 );
		}

		return $probs;
	}
		
	/** Formula del juego */
	public function siguiente_estado()
	{
		/* DANI & PEDRO */
		

	}
}
