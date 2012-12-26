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
public class Pintarse extends AccionSingleton
{
	
  /* Aplica las mejoras inmediatas y para el proximo partido */
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

  /* Restaurar valores tras el partido */
  public function finalizar()
  {
    /* TODO: solo restar el ambiente (no restar los recursos) */
  }	
}