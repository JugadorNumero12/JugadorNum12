<?php

/** 
 * Contactar con la Yakuza japonesa
 * 
 * POR DETERMINAR
 *
 *
 * @package componentes\acciones
 */
class ContactarYakuza extends AccionPartSingleton
{
 	/**
   	 * Funcion para acceder al patron Singleton
   	 *
     * @static
     * @return \ContactarYakuza instancia de la accion 
     */
	public static function getInstance()
   	{
      if (!self::$instancia instanceof self) {
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
      // TODO
	}

 	/**
   	 * POR DETERMINAR
   	 * @return void
   	 */
	public function finalizar() 
  {
    // TODO
  }

}
