<?php

class Formula
{
	const PESOS_MULT = 2048;
	const PESOS_MIN = 1;

	/**
	 * @param $x Punto en el que calcular la normal
	 * @return La normal acumulada en el punto $x
	 */
	// Algoritmo encontrado en StackOverflow para calcular la normal
	// acumulada en un punto. Viva StackOverflow.
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

	/**
	 * @param $x Punto en el que calcular la normal
	 * @param $avg Media de la normal a calcular
	 * @param $stdev Desviación típica de la normal acalcular
	 * @return La normal N($avg,$stdev) en el punto $x
	 */
	private static function gauss ( $x, $avg, $stdev ) {
		return self::cumnormdist(($x - $avg)/$stdev);
	}

	private static function calcMedia (array $params) {
		// Inicialmente, la media es el estado actual
		$avg = $params['estado'];

		// Acercamos la media al punto de equilibrio	
		$factDifNiv = 0.4;
		$avg += ($params['difNiv'] - $params['estado']) * $factDifNiv;

		return $avg;
	}

	private static function calcDesv (array $params) {
		// Desviación inicial con valor arbitrario
		$stdev = 3;

		// La curva es más aplastada en el centro
		$stdev *= 1 - abs($params['estado'])*0.08;

		return $stdev;
	}


	public static function pesos (array $params) {
		$pesos = array();

		for ( $i=-10; $i<=10; $i++ ) {
			$avg = self::calcMedia($params);
			$stdev = self::calcDesv($params);

			//if ( $i == -10 ) {
			//	$p = self::gauss( -9.5, $avg, $stdev );
			//} else if ( $i == 10 ) {
			//	$p = (1 - self::gauss( 9.5, $avg, $stdev ));
			//} else {
			$p = self::gauss( $i+0.5, $avg, $stdev ) - self::gauss( $i-0.5, $avg, $stdev );
			//}

			$pesos[$i] = (int) (($p * self::PESOS_MULT) + self::PESOS_MIN);
		}

		return $pesos;
	}

	/**
	 * Obtiene un array de {@link #pesos} y lo transforma en probabilidades,
	 * dividiendo cada elemento entre la suma de todos
	 *
	 * @param $params Array de parámetros de la fórmula
	 */
	public static function probabilidades (array $params) {
		$pesos = self::pesos($params);
		$tot = array_sum( $pesos );
		foreach ( $pesos as $i=>$v ) {
			$probs[$i] = $v/$tot;
		}

		return $probs;
	}
	
	/**
	 * Calcula de forma aleatoria el siguiente estado, basado en las
	 * probabilidades calculadas por {@link #probabilidades} y
	 * los parámetros dados.
	 *
	 * @param $params Array de parámetros de la fórmula
	 */
	public static function siguienteEstado (array $params)
	{
		/* DANI & PEDRO ==> Ingenieros de LA FÓRMULA */
		$probs = self::probabilidades($params);
		
		// PHP >4.2.0 -- No necesita llamada a mt_srand()
		$rnd = mt_rand() / mt_getrandmax();

		$acc = 0;
		foreach ( $probs as $i=>$v ) {
			$acc += $v;
			if ( $rnd <= $acc ) {
				return $i;
			}
		}

		return null;
	}
}
