<?php

/** 
 * Descripcion breve: Financiar evento promocional
 * Tipo: Accion grupal
 * Perfil asociado: Empresario
 *
 * Efectos
 * 	 aumenta aforo para el proximo partido 
 *	 aumenta ambiente para el proximo partido
 *
 * Bonus al creador
 * 	 ninguno
 */
class FinanciarEvento extends AccionGrupSingleton
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
    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",Efectos::$datos_acciones['FinanciarEvento']['ambiente']));
    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"aforo",Efectos::$datos_acciones['FinanciarEvento']['aforo']));

    //2.- Dar bonificación al creador

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

  /* Restaurar valores tras el partido. NO ES NECESARIO YA. */
  public function finalizar()
  {
  }	
}