<?php

/* TODO RECOGER CONSTANTES DE LA TABLA .XML */

/** 
 * Descripcion breve: Grupo de aficionados pintados con los colores del equipo
 * Tipo: Grupal
 * Perfil asociado: Ultra, Movedora
 *
 * Efectos:
 *    Aumenta de forma inmediata el animo de los participantes
 *    Aumenta el factor de partido ambiente para el proximo partido
 *
 * Bonus al creador:
 *    Aumento extra del animo
 */
class Pintarse extends AccionGrupSingleton
{
	
  /* Aplica las mejoras inmediatas y para el proximo partido */
  public function ejecutar($id_accion)
  {
      //Tomar helper para facilitar la modificación
      Yii::import('application.components.Helper');

      $ret = 0;

      $accGrup = AccionesGrupales::model()->findByPk($id_accion);
      if ($accGrup == null)
        throw new Exception("Accion grupal inexistente.", 404);
        
      $creador = $accGrup->usuarios;
      $equipo = $creador->equipos;
      $sigPartido = $equipo->sigPartido;

      //1.- Añadir bonificación al partido
      $helper = new Helper();
      $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",$datos_acciones['Pintarse']['ambiente']));
      
      //2.- Dar bonificación al creador
      $ret = min($ret,$helper->aumentar_recursos($creador->id_usuario,"animo",$datos_acciones['Pintarse']['bonus_creador']['animo']));
      
      //3.- Devolver influencias y dar animo de la accion

      $participantes = $accGrup->participaciones;
      foreach ($participaciones as $participacion)
      {
        $infAportadas = $participacion->influencas_aportadas;
        $usuario = $participacion->usuarios_id_usuario;
        $ret = min($ret,$helper->aumentar_recursos($usuario,"animo",$datos_acciones['Pintarse']['animo']));
        $ret = min($ret,$helper->aumentar_recursos($usuario,"influencias",$infAportadas));
      }

      //Finalizar función
      return $ret;
  }

  /* Restaurar valores tras el partido. NO ES NECESARIO */
  public function finalizar()
  {
  }	
}