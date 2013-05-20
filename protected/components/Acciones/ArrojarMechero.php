<?php

/** 
 * Descripcion breve: Apuntar con puntero laser al lanzador de falta rival
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos
 *  aumenta el factor de partido "defensivo"
 */
class ArrojarMechero extends AccionPartSingleton
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
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"defensivo",Efectos::$datos_acciones['ArrojarMechero']['defensivo']));
      // Incorporo un registro a la tabla acciones turno si el usuario aun no esta en ella
      AccionesTurno::incorporarAccion($id_usuario, $id_partido,$id_equipo);
      //Finalizar función
      return $ret;
  }

  public function finalizar() {}
}