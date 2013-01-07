<?php

/** 
 * Descripcion breve: Retransmitir el encuentro por las redes sociales (RRSS)
 * Tipo: Partido
 * Perfil asociado: Ultra, Movedora
 *
 * Efectos:
 *  Aumenta el factor de partido "defensivo"
 *  Aumenta de forma inmediata el recurso animo del jugador
 */
public class RetransmitirRRSS extends AccionSingleton
{
	/* Aplicar los efectos de la accion */
	public void ejecutar()
	{
		/* TODO */
		 $trans=Yii::app()->db->beginTransaction();
	    try
	    {
	    	$helper = new Helper();
	      	/*Aumentar el recurso animo del jugador*/
	    	 $id = Yii::app()->user->usIdent;    		  
     		 $columna = 'animo';
     		 $cantidad = $datos_acciones['RetransmitirRRSS']['animo'];
     		 $help->aumentar_recursos($id, $columna, $cantidad); 
     		 
	      	/*Aumentar el factor de partido "defensivo"*/
     		/*Voy a coger el factor defensivo del equipo y lo voy a aumentar*/
     		/*Creo que esto lo deberia modificar en Turnos ya que afecta al partido
     		 si esta accion fallara sera probablemente por eso,cambiarlo si es asi*/
     		 $id_equipo=Yii::app()->user->usAfic;
     		 $equipo=Equipos::model()->findByPK($id_equipo);
     		 $cantidad=$datos_acciones['RetransmitirRRSS']['defensivo'];
     		 $nuevo_defensivo=$equipo->factor_defensivo +$cantidad;
     		 $equipo->->setAttributes(array('factor_defensivo'=>$nuevo_defensivo));

     		 
	      	$trans->commit();
	    }
	    catch (Exception $e)
	    {
	      $trans->rollBack();
	    }  
	}

	/* restarurar valores tras el partido */
	public void finalizar()
	{
		/* TODO */
	}
}