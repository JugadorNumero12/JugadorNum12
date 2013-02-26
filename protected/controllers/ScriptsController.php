<?php

/* Esta api permite llamar y testear los diferentes scripts. */
class ScriptsController extends Controller
{
	/**
	 * @return array de filtros para actions
	 */
	public function filters()
	{
		return array(
			'accessControl', // Reglas de acceso
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Especifica las reglas de control de acceso.
	 * Esta función es usada por el filtro "accessControl".
	 * @return array con las reglas de control de acceso
	 */
	public function accessRules()
	{
		return array(
			array('allow', // Permite realizar a todos los usuarios
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Selecciona los partidos en juego y ejecuta sus turnos correspondientes.
	 *
	 * @ruta jugadorNum12/scriptsApi/jugarPartido
	 */
	public function actionEjecutarTurno()
	{
		Yii::import('application.components.Partido');

		$tiempo=time();
		$primerTurno=Partido::PRIMER_TURNO;
		$ultimoTurno=Partido::ULTIMO_TURNO;
		$busqueda=new CDbCriteria;
		$busqueda->addCondition(':bTiempo >= hora');
		$busqueda->addCondition('turno >= :bPrimerTurno');
		$busqueda->addCondition('turno <= :bUltimoTurno');
		$busqueda->params = array(':bTiempo' => $tiempo,
								'bPrimerTurno' => $primerTurno,
								'bUltimoTurno' => $ultimoTurno);
		$partidos=Partidos::model()->findAll($busqueda);

		foreach ($partidos as $partido)
		{
        	$transaction = Yii::app()->db->beginTransaction();
        	try
        	{
				$partido = new Partido($partido->id_partido);
				$partido->jugarse();   
				$transaction->commit();     		
        	}
        	catch (Exception $ex)
        	{
        		$transaction->rollback();
        		throw $ex;
        	}
		}
	}


	/**
	 * Simulador de la fórmula
	 */
	public function actionFormula($dn=0, $am=0, $al=0, $av=0, $ml=0, $mv=0, $ol=0, $ov=0, $dl=0, $dv=0)
	{
		// Creamos el array de parámetros a partir de los datos GET
		$params = array(
 			'difNiv'    => (double) $dn, 'aforoMax'  => (double) $am,
 			'aforoLoc'  => (double) $al, 'aforoVis'  => (double) $av,
			'moralLoc'  => (double) $ml, 'moralVis'  => (double) $mv,
			'ofensLoc'  => (double) $ol, 'ofensVis'  => (double) $ov,
			'defensLoc' => (double) $dl, 'defensVis' => (double) $dv,
		);

		// Obtenemos los pesos y las probabilidades de todos los estados
		for ($i = -10; $i <= 9; $i++) {
			$params['estado'] = ($i == -10) ? null : $i;

			$pesos[$params['estado']] = Formula::pesos($params);
			$probs[$params['estado']] = Formula::probabilidades($params);
		}

		// Calculamos los colores para la tabla
		foreach ( $probs as $i=>$v ) {
			$max = max($v);
			foreach ( $v as $ii=>$vv ) {
				$r = 255;
				$g = 255 - (int) round($vv*255);
				$b = 255 - (int) round(($vv/$max)*255);
				$colors[$i][$ii] = "rgb($r,$g,$b)";
			}
		}

		// Simulamos un partido con todos los estados iniciales
		for ( $i = -9; $i <= 9; $i++ ) {
			$estados[$i] = array($i);
			$params['estado'] = $i;

			for ( $t = 0; $t < 12; $t++ ) {
				$estSig = Formula::siguienteEstado($params);

				$params['estado'] = $estSig;
				$estados[$i][] = $estSig;
			}
		}

		foreach ($estados as $i=>$v) {
			foreach ($v as $ii=>$vv) {
				if ( $vv < 0 ) {
					$nc = (int)( 255 * (1 + $vv/10) );
					$c = "rgb(255,$nc,$nc)";
				} else if ( $vv > 0) {
					$nc = (int)( 255 * (1 - $vv/10) );
					$c = "rgb($nc,$nc,255)";
				} else {
					$c = 'white';
				}
				$estColors[$i][$ii] = ($c);
			}
		}

		// Dibujamos la vista
		unset($params['estado']);
		
		$this->layout = "main";
		$this->render('formula', array(
			'probs'=>$probs,
			'pesos'=>$pesos,
			'colors'=>$colors,
			'params'=>$params,
			'estados'=>$estados,
			'estColors'=>$estColors
		));
	}
}
