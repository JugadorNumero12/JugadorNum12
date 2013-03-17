<?php

/** 
 * Descripcion breve: Promover el partido por las redes sociales para conseguir aforo
 * Tipo: Grupal
 * Perfil asociado: Movedora
 *
 * Efectos:
 *  Aumenta el factor de partido "ambiente" para el proximo partido
 *  Aumenta el factor de partido "aforo" para el proximo partido
 *
 * Bonus al creador:
 *  Ninguo 
 */
class PromoverPartido extends AccionGrupSingleton
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
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",Efectos::$datos_acciones['PromoverPartido']['ambiente']));
	    $ret = min($ret,$helper->aumentar_factores_prop($sigPartido->id_partido,$equipo->id_equipo,"aforo",Efectos::$datos_acciones['PromoverPartido']['aforo']));
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"moral",Efectos::$datos_acciones['PromoverPartido']['moral']));
	    
	    //2.- Dar bonificación al creador
	    
	    //3.- Devolver influencias

	    $participantes = $accGrup->participaciones;
	    foreach ($participantes as $participacion)
	    {
	      $infAportadas = $participacion->influencias_aportadas;
	      $usuario = $participacion->usuarios_id_usuario;
	      if ($helper->aumentar_recursos($usuario,"influencias",$infAportadas) == 0)
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

	/* restarurar valores tras el partido. NO ES NECESARIO */
	public function finalizar()
	{
	}
}