<?php

class Formula
{

	const PESOS_DIST_CERCA = 8;

	const PESOS_MIN_CERCA = 16;
	const PESOS_MIN_LEJOS = 3;
	const PESOS_INICIAL = 256;
	const PESOS_MULT = 12000;

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
	 * Calcula el punto de equilibrio al cual debe tender el partido en reposo.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Punto deequilibrio del partido
	 */
	private static function equilibrio (array &$params) {
		// Algunos valores para esta implementación ([difNiv] => equilibrio):
	    // [0]  => 0.000   [1]  => 1.257
	    // [2]  => 2.422   [3]  => 3.440
	    // [4]  => 4.296   [5]  => 5.000
	    // [7]  => 6.051   [9]  => 6.772
	    // [11] => 7.284   [15] => 7.952
	    // Los valores para diferencias de nivel negativas devuelven
	    // los mismos valores, pero negativos, como es de esperar.
		return atan($params['difNiv']*0.2) / pi() * 2 * 10;

		// == DANI ==
		// Utilizo la función matemática arco-tangente:
		// * Para una diferencia de niveles de -infinito, el resultado es -PI
		// * Para una diferencia de niveles de +infinito, el resultado es +PI
		// * Para una diferencia de niveles de 0, el resultado es 0.
		// Ajustando los factores para que en lugar de estar entre -PI/+PI esté entre
		// -10/+10 (En cuyo caso harían falta valores INMENSOS para que el partido siempre
		// tendiera a gol) tenemos una función bastante interesante.
	}

	/**
	 * Calcula la media de la función final dados los parámetros para el turno.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Media de la función final
	 */
	private static function calcMedia (array &$params) {
		$equilibrio = self::equilibrio($params);

		// Inicialmente, la media es el estado actual o, si es null, el punto de equilibrio
		if ($params['estado'] === null) {
			$avg = $equilibrio;

		} else {
			$avg = $params['estado'];

			// Acercamos la media al punto de equilibrio	
			$factDifNiv = self::DIFNIV_NFACT_BASE + ($params['moralLoc'] + $params['moralVis'])/10;
			$avg += ($equilibrio - $params['estado']) * exp(-$factDifNiv/100);
		}

		//Hacemos la diferencia de morales en valor absoluto
		//tenemos en cuenta el aforo y lo sumamos a la moral que tienen
		$difMoral = ($params['moralLoc']+$params['aforoLoc'])-  ($params['moralVis']+$params['aforoVis']);
		$avg += ($difMoral>0 ? atan($difMoral/1000) : -atan($difMoral/1000)) * 3.5* ($difMoral>0 ? 10 - $avg : -10 - $avg );
		return $avg;
	}

	/**
	 * Calcula la desviación típica de la función final dados los parámetros
	 * para el turno.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Desviación típica de la función final
	 */
	private static function calcDesv (array &$params) {
		// Desviación inicial con valor arbitrario
		$stdev = 2.5;

		// La curva es más aplastada en el centro
		$stdev *= 1 - abs($params['estado'])*0.05;

		//Los dos equipos son muy ofensivos
		if($params['ofensLoc']>20 && $params['ofensVis']>20)
		{
			$stdev *= 0.9;
		}elseif($params['ofensLoc']>10 && $params['ofensVis']>10)
				{
					$stdev *= 1.2;
				}
		if($params['defensLoc'] >20 && $params['defensVis']>20)
		{
			$stdev *= 2;
		}elseif($params['defensLoc']>10 && $params['defensVis']>10)
				{
					$stdev *= 1.5;
				}

		return $stdev;
	}

	/**
	 * Devuelve un array de los pesos que indicarán la probabilidad de cada
	 * cambio de estado.
	 *
	 * @param $params Array de parámetros de la fórmula
	 * @return Pesos de los cambios de estado
	 */
	public static function pesos (array &$params) {
		$pesos = array();

		for ( $i=-10; $i<=10; $i++ ) {
			// Obtenemos la medio y la desviación típica
			$avg = self::calcMedia($params);
			$stdev = self::calcDesv($params);

			// Calculamos la probabilidad, según una normal N($avg,$stdev), de llegar al estado $i:
			// * Para la prob. entre -9 y +9, calculamos la acumulada entre $i-0.5 e $i+0.5
			// * Para la prob. de -10, calculamos la acumulada desde -infinito hasta -9.5
			// * Para la prob. de +10, calculamos la acumulada desde +9.5 hasta +infinito
			if ( $i == -10 ) {
				$p = self::gauss( -9.5, $avg, $stdev );
			} else if ( $i == 10 ) {
				$p = (1 - self::gauss( 9.5, $avg, $stdev ));
			} else {
				$p = self::gauss( $i+0.5, $avg, $stdev ) - self::gauss( $i-0.5, $avg, $stdev );
			}

			// Multiplicamos el peso por un factor constante para hacerlo
			// más preciso unavez convertido a int
			$pm = $p * self::PESOS_MULT;
			if ($params['estado'] !== null) {
				// Si se trata de un estado normal, sumamos un peso mínimo
				// NOTA: Sólo se suma peso al gol si estamos "cerca"
				$cerca = abs($i-$params['estado']) < self::PESOS_DIST_CERCA;
				$pm += $cerca ? self::PESOS_MIN_CERCA : self::PESOS_MIN_LEJOS;
				if ( abs($i) == 10 ) {
					$pm -= self::PESOS_MIN_LEJOS;
				}

			} else {
				// Si el estado es un inicial (Previo al partido, tras el descanso o un gol):
				// * Eliminamos por completo la probabilidad de alcanzar el estado +10/-10
				// * Reducimos por una constante el peso de todos los estados
				// * Reducimos al 33,3% el peso del estado +9/-9
				// * reducimos al 66,7% el peso del estado +8/-8
				if (abs($i) == 10) {
					$pm = 0;
				} else {
					$pm -= self::PESOS_INICIAL;
					if ( abs($i) == 9) {
						$pm *= .333;
					} else if ( abs($i) == 8) {
						$pm *= .667;
					}
				}
			}

			// Convertimos el peso a int y lo añadimos al resultado
			$pesos[$i] = max( 0, (int) $pm );
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
	public static function probabilidades (array &$params) {
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
	public static function siguienteEstado (array &$params)
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

		die( '<pre>' . print_r(array($probs,$rnd), true) . '</pre>' );
		return null;
	}
}
