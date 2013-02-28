<?php

/** 
 * Descripcion breve: Apuntar con puntero laser al lanzador de falta rival
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos
 *  aumenta el factor de partido "defensivo"
 */
class PunteroLaser extends AccionPartSingleton
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
    //Tomar helper para facilitar la modificación
      Yii::import('application.components.Helper');

      $ret = 0;

      $creador = Usuarios::model()->findByPk($id_usuario);
      if ($creador == null)
        throw new Exception("Usuario inexistente.", 404);
        
      $equipo = $creador->equipos;
      $sigPartido = $equipo->sigPartido;

      //1.- Añadir bonificación al partido
      $helper = new Helper();
      $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"defensivo",Efectos::$datos_acciones['PunteroLaser']['defensivo']));

      //Finalizar función
      return $ret;
  }

  public function finalizar() {}
}