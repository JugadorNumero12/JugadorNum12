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
public class FinanciarEvento extends AccionSingleton
{	
  /* Aplicar los efectos de la accion */
  public function ejecutar($id_accion)
  {
      $trans = Yii::app()->db->beginTransaction();
      try{
        $helper = new Helper();
        
        //TODO

        $trans->commit();
      } catch {
        $trans->rollBack();
      }
  }

  /* Restaurar valores tras el partido */
  public function finalizar()
  {
  	/* TODO */
  }	
}