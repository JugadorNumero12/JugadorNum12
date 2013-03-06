<?php

/** 
 * Descripcion breve: Crearse espectativas para el proximo partido (motivarse)
 * Tipo: Individual
 * Perfil asociado: Todos
 *
 * Efectos:
 *  Proporciona animo inmediato para el proximo partido. 
 *  NOTA: aun no implementar que si se gana el partido aporta un extra y se reduce si se pierde el partido
 */
class CrearseEspectativas extends AccionIndSingleton
{
	  /* Función a través de la cual se accederá al Singleton */
	   public static function getInstance()
	   {
	      if (!self::$instancia instanceof self)
	      {
	         self::$instancia = new self;
	      }
	      return self::$instancia;
	   }

	  /* Ningun efecto al ejecutar la accion */
	  public function ejecutar($id_usuario)
	  {
    	//Traer el array de efectos
    	parent::ejecutar($id_usuario);

		//Validar usuario
		$us = Usuarios::model()->findByPk($id_usuario);
		if ($us === null)
			throw new Exception("Usuario incorrecto.", 404);			

		//Tomar helper para facilitar la modificación
		Yii::import('application.components.Helper');

		//Aumentar ánimo
		$helper = new Helper();
		if ($helper->aumentar_recursos($id_usuario,"animo",Efectos::$datos_acciones['CrearseEspectativas']['animo']) == 0)
		{
			return 0;
		}
		else
		{
			return -1;
		}
	}

	/* Restarurar valores tras el partido */
	public function finalizar($id_usuario,$id_habilidad)
	{
		/* NOTA: No hacer todavia que se gane extra de animo si se ganara el partido, ni que se perdiera */
		//Comprobaciones de parámetros realizadas e influencias devueltas en la llamada al padre. 
		//No es necesario realizar nada extra.
		$res = parent::finalizar($id_usuario,$id_habilidad);
		return $res;
	}
}