<?php

/** 
 * Doblar la apuesta durante el partido
 * 
 * Tipo : Partido
 *
 * Efectos
 *
 * - Por determinar
 *
 *
 * @package componentes\acciones
 */
class DoblarApuesta extends AccionPartSingleton
{
 	/**
   	 * Funcion para acceder al patron Singleton
   	 *
     * @static
     * @return \DoblarApuesta instancia de la accion 
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
      $ret =0 ; 
      //Traer el array de efectos
      parent::ejecutar($id_usuario,$id_partido,$id_equipo);

      //Validar usuario
      $us = Usuarios::model()->findByPk($id_usuario);
      if ($us === null)
        throw new Exception("Usuario incorrecto.", 404); 
      
      // Modifico Los factores de ese partido
      $ret = min($ret,Recursos::aumentar_recursos($id_usuario,"dinero",Efectos::$datos_acciones['DoblarApuesta']['dinero']));
      
      // Incorporo un registro a la tabla acciones turno si el usuario aun no esta en ella
      AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);
     //Finalizar función
      return $ret;
	}

 	/**
   	 * Accion de partido: sin efecto en finalizar() 
   	 * @return void
   	 */
	public function finalizar() {}

}
