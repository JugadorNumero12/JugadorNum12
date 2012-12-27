<?php

/** 
 * Descripcion breve: Ascender en el trabajo
 * Tipo: Individual
 * Perfil asociado: Empresario, Ultra
 *
 * Efectos:
 * 	Aumenta de forma permanente la generacion de dinero
 */
public class Ascender extends AccionSingleton
{
  /* Aplicar los efectos de la accion */
  public function ejecutar($id_accion)
  {
    //Inicialmente no usamos el $id_accion
    $trans=Yii::app()->db->beginTransaction();
    try
    {
      //Aumentar generación de dinero
      $id = Yii::app()->user->usIdent;        
      $modelo = Recursos::model()->findByPk($id);
      $gen_base = $modelo->getAttribute('dinero_gen');
      $gen_mod = $gen_base + 0.12;
      $modelo->setAttributes(array('dinero_gen'=>$gen_mod));
      if ($modelo->save()) 
      {
        $trans->commit();
      }
      else
      {
        $trans->commit(); 
      } 
    }
    catch (Exception $e)
    {
      $trans->rollBack();
    }      
  }

  /* Accion permanente: metodo vacio */
  public function finalizar()
  {
    $trans=Yii::app()->db->beginTransaction();
    try
    {
      //Reducir generación de dinero de nuevo
      $id = Yii::app()->user->usIdent;        
      $modelo = Recursos::model()->findByPk($id);
      $gen_base = $modelo->getAttribute('dinero_gen');
      $gen_mod = $gen_base - 0.12;
      $modelo->setAttributes(array('dinero_gen'=>$gen_mod));
      if ($modelo->save()) 
      {
        $trans->commit();
      }
      else
      {
        $trans->commit(); 
      } 
    }
    catch (Exception $e)
    {
      $trans->rollBack();
    }
  }	
}