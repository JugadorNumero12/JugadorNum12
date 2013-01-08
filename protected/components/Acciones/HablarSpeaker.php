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
		$moral = $datos_acciones['HablarSpeaker']['moral'];
		$ofens = $datos_acciones['HablarSpeaker']['ofensivo'];

		$trans = Yii::app()->db->beginTransaction();
		try {
			$accion = Accion::model()->findByPk($idAccion);
			
			// FIXME Cambiar los parámetros
			Helper::getInstance()->aumentar_param(/* params */, $moral);
			Helper::getInstance()->aumentar_param(/* params */, $moral);

			$trans->commit();

		} catch ( Exception $exc ) {
			$trans->rollback();
			throw $exc;
		}
	}

	/* Accion de partido: metodo vacio */
	public function finalizar($idAccion)
	{
		/* VACIO */
	}
}