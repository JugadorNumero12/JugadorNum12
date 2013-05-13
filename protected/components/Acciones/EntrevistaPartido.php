<?php

/** 
 * Hacer entrevista durante el partido
 * 
 * Tipo : Partido
 *
 * Efectos
 *
 * - Aumenta el factor ofensivo del equipo
 * - Disminuye el factor defensivo del equipo rival
 *
 *
 * @package componentes\acciones
 */
class Entrevista extends AccionPartSingleton
{
 	/**
   	 * Funcion para acceder al patron Singleton
   	 *
     * @static
     * @return \Entrevista instancia de la accion 
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
   	 * Accion de partido: sin efecto en finalizar() 
   	 * @return void
   	 */
	public function finalizar() {}

}
