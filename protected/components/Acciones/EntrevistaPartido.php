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
      $ret =0 ; 
      //Traer el array de efectos
      parent::ejecutar($id_usuario,$id_partido,$id_equipo);

      //Validar usuario
      $us = Usuarios::model()->findByPk($id_usuario);
      if ($us === null)
        throw new Exception("Usuario incorrecto.", 404); 
      // Cojo el equipo del usuario
      $equipo = $us->equipos;
      // Modifico Los factores de ese partido
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"defensivo",Efectos::$datos_acciones['Entrevista']['defensivo']));
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"ofensivo",Efectos::$datos_acciones['Entrevista']['ofensivo']));
      
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
