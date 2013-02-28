<?php

/** 
 * Descripcion breve: Beber cerveza durante el partido
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos:
 *  Aumenta de forma inmediata el recurso animo 
 */
class BeberCerveza extends AccionPartSingleton
{
	/* Aplicar efectos de la accion */
	public function ejecutar($id_usuario)
	{
		//Validar usuario
		$us = Usuarios::model()->findByPk($id_usuario);
		if ($us === null)
			throw new Exception("Usuario incorrecto.", 404);			

		//Tomar helper para facilitar la modificación
		Yii::import('application.components.Helper');

		//Aumentar ánimo
		$helper = new Helper();
		if ($helper->aumentar_recursos($id_usuario,"animo",$datos_acciones['BeberCerveza']['animo']) == 0)
		{
			return 0;
		}
		else
		{
			return -1;
		}
	}

	public function finalizar() {}
}