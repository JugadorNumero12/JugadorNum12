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
        /*Aumentar el factor de partido "moral"*/
        /*Para cambiar el atributo moral en el único sitio que aparece es en la tabla
         Turnos. Por tanto, como aun no se coger justo el ultimo turno, voy a coger todos
         los turnos de ese partido y voy a aumentar el atributo moral.Cuando encuentre como
         coger solo el ultimo optimizare la accion*/
        $h=new Helper();
        $id_equipo=Yii::app()->user->usAfic;
        $equipo=Equipos::model()->findByPK($id_equipo);
        $cantidad=$datos_acciones['IniciarOla']['moral'];
        $h->aumentar_factores($id_partido,$id_equipo,'moral',$cantidad);
        
        
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