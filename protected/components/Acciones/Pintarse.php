<?php

/** 
 * Descripcion breve: Grupo de aficionados pintados con los colores del equipo
 * Tipo: Accion grupal
 * Perfil asociado: Ultra
 *
 * Efectos:
 *    Animo,    nivel medio
 *    Ambiente, nivel muy bajo
 *
 * Bonus al creador:
 *    Animo,    nivel bajo
 */
public class Pintarse extends AccionSingleton
{
	
  /* Mejoras inmediatas para los jugadores 
   *   Animo: +30 puntos
   * 
   * Mejoras para el proximo partido
   *   Ambiente: +1 punto
   *
   * Bonus para el creador
   *   Animo: +15 puntos 
   */
  public function ejecutar($id_accion)
  {
    $helper = new Helper();
		
 		/* coleccion usuarios que participaron */
 		$participantes = Participantes::model()->findbyPK($id_accion);

 		/* aumentar el animo de cada participante */
 		foreach ($participantes as $participante){
		  $helper->aumentar_recursos($participante["id_usuario"], "animo", 30);
	  }

    /* factores de partido */
      //TODO: ambiente
 		
    /* bonus del usuario que la inicio */
 		$creador = AccionesGrupales::model()->findbyPK($id_accion); //...
 		$helper->aumentar_recursos($creador["id_usuario"], "animo", 15);
  }

  /* Restaurar valores tras el partido
   *  Ambiente: -1 punto
   */
  public function finalizar()
  {
    /* TODO */
  }	
}