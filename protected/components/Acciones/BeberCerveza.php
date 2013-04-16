<?php

/** 
 * Beber cerveza durante el partido
 * 
 * Tipo
 *
 * - Partido
 *
 * Perfiles asociados
 *
 * - Ultra
 *
 * Efectos
 *
 * - Aumenta de forma inmediata el recurso animo
 *
 *
 * @package componentes\acciones
 */
class BeberCerveza extends AccionPartSingleton
{
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \Apostar instancia de la accion Apostar 
   */
	public static function getInstance()
   	{
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   	}

  /**
   * Ejecutar la accion
   *
   * @param int $id_usuario id del usuario que realiza la accion
   * @throws \Exception usuario no encontrado
   * @return int 0 si completada con exito ; -1 en caso contrario
   */ 
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

 	/**
   	 * Accion de partido: sin efecto en finalizar() 
   	 * @return void
   	 */
	public function finalizar() {}

}
