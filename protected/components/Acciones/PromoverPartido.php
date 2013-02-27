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
class PromoverPartido extends AccionSingleton
{
	/* Aplicar los efectos de la accion */
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
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",$datos_acciones['PromoverPartido']['ambiente']));
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"aforo",$datos_acciones['PromoverPartido']['aforo']));

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

	/* restarurar valores tras el partido. NO ES NECESARIO */
	public function finalizar()
	{
	}
}