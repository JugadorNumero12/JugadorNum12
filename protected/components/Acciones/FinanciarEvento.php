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
        
        //Busco el siguiente partido (Falta seleccionar el partido actual)
        $partido = Partidos::model()-><SELECCIONAR ENCUENTRO>;
        //Saco el ambiente nuevo y se lo añado
        $nuevoAmbiente = $partido->ambiente + $datos_acciones['FinanciarEvento']['ambiente'];
        $partido->setAttributes(array('ambiente'=>$nuevoAmbiente));  
        //Saco el aforo y se lo añado
        $nuevoAforo = $partido->aforo + $datos['FinanciarEvento']['aforo'];
        $partido->setAttributes(array('aforo'=>$nuevoAforo));  

        $partido->save();

        $trans->commit();
      } catch {
        $trans->rollBack();
      }
  }

  /* Restaurar valores tras el partido */
  public function finalizar($id_accion)
  {
  	//Aquí no hace falta hacer nada ya que al acabar el partido ya no importan sus valores
  }	
}