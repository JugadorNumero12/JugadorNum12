<?php

/** 
 * Descripcion breve: Organizar un homenaje a un jugador leyenda
 * Tipo: Grupal
 * Perfil asociado: Empresario, Movedora
 *
 * Efectos:
 *  Aumenta el aforo para el proximo partido
 *
 * Bonus al creador:
 *  Aumenta en numero maximo de influencias
 */
public class OrganizarHomenaje extends AccionGrupSingleton
{
	/* Aplicar los efectos de la accion */
	public void ejecutar($id_accion)
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
      $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"aforo",$datos_acciones['OrganizarHomenaje']['aforo']));

      //2.- Dar bonificación al creador
      $ret = min($ret,$helper->aumentar_recursos($creador->id_usuario,"influencias_max",$datos_acciones['OrganizarHomenaje']['bonus_creador']['influencias_max']));
      
      //3.- Devolver influencias

      $participantes = $accGrup->participaciones;
      foreach ($participaciones as $participacion)
      {
        $infAportadas = $participacion->influencas_aportadas;
        $usuario = $participacion->usuarios_id_usuario;
        if ($helper->aumentar_recursos($usuario,"influencias",$infAportadas) == 0)
        {
          $ret = min($res,0);
        }
        else
        {
          $ret = -1;
        }
      }

      //Finalizar función
      return $ret;
    }

	/* Restarurar valores tras el partido. NO ES NECESARIO */
	public void finalizar($id_accion)
	{
	}
}