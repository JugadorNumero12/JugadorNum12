<?php

/** 
 * Descripcion breve: Incentivar economicamente a los jugadores
 * Tipo: Grupal
 * Perfil asociado: Empresario
 *
 * Efectos:
 *  Aumenta hasta el proximo partido el factor de partido "nivel_equipo"
 *
 * Bonus al creador:
 *  Recupera de forma inmediata influencias empleadas en otras acciones
 */
class IncentivoEconomico extends AccionGrupSingleton
{
	
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
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"nivel",$datos_acciones['IncentivoEconomico']['nivel_equipo']));

	    //2.- Dar bonificación al creador
		$ret = min($ret,$helper->aumentar_recursos($creador->id_usuario,"influencias",$datos_acciones['IncentivoEconomico']['bonus_creador']['influencias']));
	    
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