<?php

/** 
 * Descripcion breve: Ascender en el trabajo
 * Tipo: Individual - PASIVA
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
      $columna = 'dinero_gen';
      $cantidad = $datos_acciones['Ascender']['dinero_gen'];
      $help = new Helper();
      $help->aumentar_recursos($id, $columna, $cantidad) 
      $trans->commit();
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
      $columna = 'dinero_gen';
      $cantidad = $datos_acciones['Ascender']['dinero_gen'];
      $help = new Helper();
      $help->quitar_recursos($id, $columna, $cantidad) 
      $trans->commit();
    }
    catch (Exception $e)
    {
      $trans->rollBack();
    }
  }	
}