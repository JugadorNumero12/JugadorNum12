<?php

/** 
 * Descripcion breve: Pelea entre aficiones en la grada
 * Tipo: Partido
 *
 * Efectos:
 *  Aumenta el factor ofensivo
 *  Aumenta el ambiente
 */
class TumultoGradas extends AccionPartSingleton
{
   /**
    * Acceso al patron Singleton
    * @static
    * @return void
    */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self) {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

	/**
	 * Aplicar los efectos de la accion
	 * @return void
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
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"ofensivo",Efectos::$datos_acciones['TumultoGradas']['ofensivo']));
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"ambiente",Efectos::$datos_acciones['TumultoGradas']['ambiente']));
      // Incorporo un registro a la tabla acciones turno si el usuario aun no esta en ella
      AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);
       //Finalizar función
      return $ret;
	}

	/** Accion de partido : Sin efecto en finalizar */
	public function finalizar(){ }

}