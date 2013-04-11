<?php

/** 
 * Descripcion breve: Iniciar una ola entre el publico
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos
 *  aumenta el factor de partido "moral"
 */
class IniciarOla extends AccionPartSingleton
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
  public function ejecutar($id_usuario)
  {
      $ret =0 ; 
      //Traer el array de efectos
      parent::ejecutar($id_usuario);

      //Validar usuario
      $us = Usuarios::model()->findByPk($id_usuario);
      if ($us === null)
        throw new Exception("Usuario incorrecto.", 404); 
      // Cojo el equipo del usuario
      $equipo = $us->equipos;
      // Modifico Los factores de ese partido
      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"moral",Efectos::$datos_acciones['IniciarOla']['moral']));
       //Finalizar función
      return $ret;
  }

  public function finalizar() {}
}