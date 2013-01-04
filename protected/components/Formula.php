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

	// Viva StackOverflow
	private static function cumnormdist($x)
	{
		$b1 =  0.319381530;
		$b2 = -0.356563782;
		$b3 =  1.781477937;
		$b4 = -1.821255978;
		$b5 =  1.330274429;
		$p  =  0.2316419;
		$c  =  0.39894228;

		if ($x >= 0.0) {
			$t = 1.0 / ( 1.0 + $p * $x );
			return (1.0 - $c * exp( -$x * $x / 2.0 ) * $t * ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
		} else {
			$t = 1.0 / ( 1.0 - $p * $x );
			return ( $c * exp( -$x * $x / 2.0 ) * $t * ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
		}
	}

	public static function gauss ( $x, $avg, $stdev ) {
		return self::cumnormdist(($x - $avg)/$stdev);
	}

	public static function probabilidades ( $actual ) {
		$probs = array();
		for ( $i=-10; $i<=10; $i++ ) {
			$probs[$i] = self::gauss( $i+0.5, $actual, 1 ) - self::gauss( $i-0.5, $actual, 1 );
		}

		return $probs;
	}
		
	/** Formula del juego */
	public function siguiente_estado()
	{
		/* DANI & PEDRO ==> Ingenieros de LA FÓRMULA */
		$probs = probabilidades($estado);
	}
}
