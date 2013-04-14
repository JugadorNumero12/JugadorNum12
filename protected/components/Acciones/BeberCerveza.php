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
   /* Función a través de la cual se accederá al Singleton */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

	/* Aplicar efectos de la accion */
	public function ejecutar($id_usuario,$id_partido,$id_equipo)
	{
		//Traer el array de efectos
	    parent::ejecutar($id_usuario);

	    //Validar usuario
	    $us = Usuarios::model()->findByPk($id_usuario);
	    if ($us === null)
	      throw new Exception("Usuario incorrecto.", 404);      

	    //Aumentar ánimo
	    if (Recursos::aumentar_recursos($id_usuario,"animo",Efectos::$datos_acciones['BeberCerveza']['animo']) == 0)
	    {
	      return 0;
	    }
	    else
	    {
	      return -1;
	    }
	    // Incorporo un registro a la tabla acciones turno si el usuario aun no esta en ella
	    AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);
	}

	public function finalizar() {}
}