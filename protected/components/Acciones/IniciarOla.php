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
  /* Aplicar los efectos de la accion */
  public function ejecutar($id_usuario)
  {
    //Tomar helper para facilitar la modificación
      Yii::import('application.components.Helper');

      $ret = 0;

      $creador = Usuarios::model()->findByPk($id_usuario);
      if ($creador === null)
        throw new Exception("Usuario inexistente.", 404);
        
      $equipo = $creador->equipos;
      $sigPartido = $equipo->sigPartido;

      //1.- Añadir bonificación al partido
      $helper = new Helper();
      $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"moral",$datos_acciones['IniciarOla']['moral']));

      //Finalizar función
      return $ret;
  }

  public function finalizar() {}
}