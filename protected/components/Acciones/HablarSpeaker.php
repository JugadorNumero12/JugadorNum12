<?php

/** 
 * Descripcion breve: Hablar con el speaker del partido
 * Tipo: Partido
 * Perfil asociado: Movedora
 *
 * Efectos:
 *  Aumenta el factor de partido "moral_propio"
 *  Aumenta el factor de partido "ofensivo_propio"
 */
class HablarSpeaker extends AccionSingleton
{
	/* Aplicar los efectos de la accion */
	public function ejecutar($idAccion)
	{

		$trans = Yii::app()->db->beginTransaction();
		try {
			$accion = Accion::model()->findByPk($idAccion);
			
			// FIXME Cambiar los parámetros
			Helper::getInstance()->aumentar_param(/* params */0, $moral);
			Helper::getInstance()->aumentar_param(/* params */0, $moral);

			$trans->commit();

		} catch ( Exception $exc ) {
			$trans->rollback();
			throw $exc;
		}
	}
}