<?php

class Formula
{

	const PESOS_DIST_CERCA = 10;

	const PESOS_MIN_CERCA = 10;
	const PESOS_MIN_LEJOS = 1;
	const PESOS_INICIAL = 100;
	const PESOS_MULT = 10000;

	const DIFNIV_NFACT_BASE = 100;

	/**
	 * @param $x Punto en el que calcular la normal
	 * @return La normal acumulada en el punto $x
	 */
	private static function cumnormdist($x)
	{
		// Algoritmo encontrado en StackOverflow para calcular la normal
		// acumulada en un punto. Viva StackOverflow.

		$b1 =  0.319381530;
		$b2 = -0.356563782;
		$b3 =  1.781477937;
		$b4 = -1.821255978;
		$b5 =  1.330274429;
		$p  =  0.231641900;
		$c  =  0.398942280;

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

	/**
	 * Calcula la media de la función final dados los parámetros para el turno.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Media de la función final
	 */
	private static function calcMedia (array $params) {
		// Inicialmente, la media es el estado actual o, si es null, el punto de equilibrio
		if ($params['estado'] == null) {
			$avg = $params['difNiv'];

		} else {
			$avg = $params['estado'];

			// Acercamos la media al punto de equilibrio	
			$factDifNiv = self::DIFNIV_NFACT_BASE + ($params['moralLoc'] + $params['moralVis'])/10;
			$avg += ($params['difNiv'] - $params['estado']) * exp(-$factDifNiv/100);
		}

		//Hacemos la diferencia de morales en valor absoluto
		$difMoral = $params['moralLoc'] -  $params['moralVis'];
		$avg += atan($difMoral/1000) * 0.6 * ($difMoral>0 ? 10 - $avg : -10 - $avg );

		return $avg;
	}

	/**
	 * Calcula la desviación típica de la función final dados los parámetros
	 * para el turno.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Desviación típica de la función final
	 */
	private static function calcDesv (array $params) {
		// Desviación inicial con valor arbitrario
		$stdev = 2.5;

		// La curva es más aplastada en el centro
		$stdev *= 1 - abs($params['estado'])*0.07;

		return $stdev;
	}

	/**
	 * Devuelve un array de los pesos que indicarán la probabilidad de cada
	 * cambio de estado.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Pesos de los cambios de estado
	 */
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

			$cerca = abs($i-$params['estado']) < self::PESOS_DIST_CERCA;

			$pm = $p * self::PESOS_MULT;
			if ($params['estado']) {
				$pm += $cerca ? self::PESOS_MIN_CERCA : self::PESOS_MIN_LEJOS;
			} else {
				if (abs($i) == 10) {
					$pm = 0;
				} else {
					$pm -= self::PESOS_INICIAL;
					$pm = max($pm,0);
					if ( abs($i) == 9) {
						$pm *= .33;
					} else if ( abs($i) == 8) {
						$pm *= .66;
					}
				}
			}
			$pesos[$i] = (int) $pm;
		}

		return $pesos;
	}

	/**
	 * Obtiene un array de {@link #pesos} y lo transforma en probabilidades,
	 * dividiendo cada elemento entre la suma de todos
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Probabilidades de los cambios de estado
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

		echo '<pre>' . print_r(array($probs,$rnd), true) . '</pre>';
		return null;
	}
}
