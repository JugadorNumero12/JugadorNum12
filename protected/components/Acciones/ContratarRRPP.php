<?php

/** 
 * Descripcion breve: Contratar un relaciones públicas hasta el siguiente partido
 * Tipo: Individual
 * Perfil asociado: Empresario, Movedora
 *
 * Efectos:
 *  Reduce el coste de influencia de todas las acciones del jugador hasta el proximo partido
 */
class ContratarRRPP extends AccionIndSingleton
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

		if ($helper->aumentar_recursos($id_usuario,"bonus_influencias",Efectos::$datos_acciones['ContratarRRPP']['bonus_jugador']['influencias']) == 0)
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
		//Comprobaciones de parámetros realizadas e influencias devueltas en la llamada al padre. 

		//Cuidado, no dura hasta el prox. partido sino mientras dure el cooldown.


		$res = parent::finalizar($id_usuario,$id_habilidad);

		//Tomar helper para facilitar la modificación
		Yii::import('application.components.Helper');

		$helper = new Helper();
		
		//Restablecer bonus_influencias
		if ($helper->quitar_recursos($id_usuario,"bonus_influencias",Efectos::$datos_acciones['ContratarRRPP']['bonus_jugador']['influencias']) == 0)
		{
			return min($res,0);
		}
		else
		{
			return -1;
		}
	}
}