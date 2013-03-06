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
   /* Función a través de la cual se accederá al Singleton */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }
	
  /* Aplica las mejoras inmediatas y para el proximo partido */
  public function ejecutar($id_accion)
  {
      //Tomar helper para facilitar la modificación
      Yii::import('application.components.Helper');

      $ret = 0;

      $accGrup = AccionesGrupales::model()->findByPk($id_accion);
      if ($accGrup === null)
        throw new Exception("Accion grupal inexistente.", 404);
        
      $creador = $accGrup->usuarios;
      $equipo = $creador->equipos;
      $sigPartido = $equipo->sigPartido;

      //1.- Añadir bonificación al partido
      $helper = new Helper();
      $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,'ambiente',Efectos::$datos_acciones['Pintarse']['ambiente']));
      
      //2.- Dar bonificación al creador
      $ret = min($ret,$helper->aumentar_recursos($creador->id_usuario,'animo',Efectos::$datos_acciones['Pintarse']['bonus_creador']['animo']));
      
      //3.- Devolver influencias y dar animo de la accion

      $participantes = $accGrup->participaciones;
      foreach ($participantes as $participacion)
      {
        $infAportadas = $participacion->influencias_aportadas;
        $usuario = $participacion->usuarios_id_usuario;
        $ret = min($ret,$helper->aumentar_recursos($usuario,"animo",Efectos::$datos_acciones['Pintarse']['animo']));
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