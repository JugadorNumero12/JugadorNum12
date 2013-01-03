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
    $trans=Yii::app()->db->beginTransaction();
    try
    {
      $helper = new Helper();
  		
   		/* coleccion usuarios que participaron */
   		$participantes = Participaciones::model()->findAllByAttributes(array('id_accion_grupal'=>$id_accion));

   		/* aumentar el animo de cada participante */
   		foreach ($participantes as $participante)
      {
  		  $helper->aumentar_recursos($participante['id_usuario'], 'animo', $datos_acciones['Pintarse']['animo']);
  	  }

      /* factores de partido */
      $fac_partido = Partidos::model()-><SELECCIONAR ENCUENTRO> 
      $nuevo_ambiente = $fac_partido->ambiente + $datos_acciones['Pintarse']['ambiente'];
      $fac_partido->setAttributes(array('ambiente'=>$nuevo_ambiente));   
      $fac_partido->save();

      /* bonus del usuario que la inicio */
   		$creador = AccionesGrupales::model()->findbyPK($id_accion);
   		$helper->aumentar_recursos($creador['id_usuario'], 'animo', $datos_acciones['Ascender']['bonus_creador']['animo']); 
      $trans->commit();
    }
    catch (Exception $e)
    {
      $trans->rollBack();
    } 
  }

  /* Restaurar valores tras el partido */
  public function finalizar()
  {
    /* TODO: solo restar el ambiente (no restar los recursos) */

    //NO FIJARSE EN ESTA PARTE, ESTÁ MAL
    $trans=Yii::app()->db->beginTransaction();
    try
    {
      /* factores de partido */
      $fac_partido = Partidos::model()-><SELECCIONAR ENCUENTRO> 
      $nuevo_ambiente = $fac_partido->ambiente - $datos_acciones['Pintarse']['ambiente'];
      $fac_partido->setAttributes(array('ambiente'=>$nuevo_ambiente));   
      $fac_partido->save();
      $trans->commit();
    }
    catch (Exception $e)
    {
      $trans->rollBack();
    } 
  }	
}