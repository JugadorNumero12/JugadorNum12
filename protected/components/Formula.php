<?php

class Formula
{
	private $estado;
 	private	$difNiveles;
 	private $aforoL;
	private $aforoV;
	private $moralL;
	private $moralV;
	private $ofL;
	private $ofV;
	private $defL;
	private $defV;

	/** Constructora */
	public function __construct ( $estado, $dif_niveles, $aforo_local ,$aforo_visitante,
					 $moral_local ,$moral_visitante ,$ofensivo_local ,$ofensivo_visitante,
					 $defensivo_local ,$defensivo_visitante )
	{
		$this->estado = $estado;
 		$this->difNiveles = $dif_niveles;
 		$this->aforoL = $aforo_local;
		$this->aforoV = $aforo_visitante;
		$this->moralL = $moral_local;
		$this->moralV = $moral_visitante;
		$this->ofL = $ofensivo_local;
		$this->ofV = $ofensivo_visitante;
		$this->defL  = $defensivo_local;
		$this->defV = $defensivo_visitante;
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

	public function pesos ( $actual ) {
		$pesos = array();

		for ( $i=-10; $i<=10; $i++ ) {
			$avg = $actual;

			// Movemos la media hacia el punto de equilibrio
			$factDifNiv = 0.2;
			$avg += ($this->difNiveles - $actual) * $factDifNiv;

			$stdev = 2;

			// La curva es más aplastadaen el centro
			$stdev *= 1 - abs($actual)*0.09;

			if ( $i == -10 ) {
				$p = self::gauss( -9.5, $avg, $stdev )*100;
			} else if ( $i == 10 ) {
				$p = (1 - self::gauss( 9.5, $avg, $stdev ))*100;
			} else {
				$p = (self::gauss( $i+0.5, $avg, $stdev ) - self::gauss( $i-0.5, $avg, $stdev ))*100;
			}

			$pesos[$i] = $p;
		}

		return $pesos;
	}

	public function probabilidades ( $actual ) {
		$pesos = $this->pesos($actual);
		$tot = array_sum( $pesos );
		foreach ( $pesos as $i=>$v ) {
			$probs[$i] = $v/$tot;
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
