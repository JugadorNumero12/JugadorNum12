<?php

/** 
 * Hablar por el speaker del estadio
 *
 * Tipo
 *
 * - Partido
 * 
 * Perfil asociado
 *
 * - RRPP
 *
 * Efectos
 *
 * - Aumenta el factor de partido "moral_propio"
 * - Aumenta el factor de partido "ofensivo_propio"
 *
 *
 * @package componentes\acciones
 */
class HablarSpeaker extends AccionPartSingleton
{
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \Apostar instancia de la accion
   */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

	/* Aplicar los efectos de la accion */
	public function ejecutar($id_usuario,$id_partido,$id_equipo)
	{
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
	    $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"moral",Efectos::$datos_acciones['HablarSpeaker']['moral']));
	    $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"ofensivo",Efectos::$datos_acciones['HablarSpeaker']['ofensivo']));
	    
	    // Incorporo un registro a la tabla acciones turno si el usuario aun no esta en ella
	    AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);
		 //Finalizar función
	    return $ret;
	}

	public function finalizar() {}
}