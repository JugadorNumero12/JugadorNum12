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
class OrganizarHomenaje extends AccionGrupSingleton
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
	public function ejecutar($id_accion)
  {
      $ret = 0;

      $accGrup = AccionesGrupales::model()->findByPk($id_accion);
      if ($accGrup === null)
        throw new Exception("Accion grupal inexistente.", 404);
        
      $creador = $accGrup->usuarios;
      $equipo = $creador->equipos;
      $sigPartido = $equipo->sigPartido;

      //1.- Añadir bonificación al partido
      $helper = new Helper();
      $ret = min($ret,Partidos::aumentar_factores_prop($sigPartido->id_partido,$equipo->id_equipo,"aforo",Efectos::$datos_acciones['OrganizarHomenaje']['aforo']));

      //2.- Dar bonificación al creador
      $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"influencias_max",Efectos::$datos_acciones['OrganizarHomenaje']['bonus_creador']['influencias_max']));
      
      //3.- Devolver influencias

      $participantes = $accGrup->participaciones;
      foreach ($participantes as $participacion)
      {
        $infAportadas = $participacion->influencias_aportadas;
        $usuario = $participacion->usuarios_id_usuario;
        if (Recursos::aumentar_recursos($usuario,"influencias",$infAportadas) == 0)
        {
          $ret = min($ret,0);
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
	public function finalizar()
	{
	}
}