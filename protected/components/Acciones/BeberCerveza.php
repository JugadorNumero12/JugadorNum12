<?php

/** 
 * Descripcion breve: Beber cerveza durante el partido
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos:
 *  Aumenta de forma inmediata el recurso animo 
 */
class BeberCerveza extends AccionSingleton
{
	/* Aplicar efectos de la accion */
	public function ejecutar($idAccion)
	{
		$animo = $datos_acciones['BeberCerveza']['animo'];

		$trans = Yii::app()->db->beginTransaction();
		try {
			$accion = Accion::model()->findByPk($idAccion);
			Helper::getInstance()->aumentar_recursos($accion['usuario_id_usuario'], 'animo', $animo);
			$trans->commit();

		} catch ( Exception $exc ) {
			$trans->rollback();
			throw $exc;
		}
	}
}