<?php

/** 
 * Descripcion breve: Iniciar una ola entre el publico
 * Tipo: Partido
 * Perfil asociado: Ultra
 *
 * Efectos
 *  aumenta el factor de partido "moral"
 */
public class Apostar extends AccionSingleton
{
  /* Aplicar el efecto de la accion */
  public function ejecutar($id_accion)
  {
  	/*ROBER */ 
      $trans=Yii::app()->db->beginTransaction();
      try
      {
        //Aumentar el factor de partido "moral"
        
        $trans->commit();
      }
      catch (Exception $e)
      {
        $trans->rollBack();
      }       
  }

  /* Accion de partido: metodo vacio */
  public function finalizar()
  {
  	/* VACIO */
  }	
}