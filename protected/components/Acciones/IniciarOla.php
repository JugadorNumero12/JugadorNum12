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
        $id_equipo=Yii::app()->user->usAfic;
        $equipo=Equipos::model()->findByPK($id_equipo);
        /*Partidos que juega como local*/
        $local=$equipo->local;
        /*Partidos que juega como visitante*/
        $visitante=$equipo->visitante;
        /*Ahora debo buscar aquel partido que tenga hora 0 y sera el que este jugandose,entonces 
        cogere todos sus turnos y les cambiare la moral*/
        
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