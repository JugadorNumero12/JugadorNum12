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
	      	//Aumentar el recurso animo del jugador
	    	 $id = Yii::app()->user->usIdent;    		  
     		 $columna = 'animo';
     		 $cantidad = $datos_acciones['RetransmitirRRSS']['animo'];
     		 $help->aumentar_recursos($id, $columna, $cantidad); 
     		 
	      	//Aumentar el factor de partido "defensivo"
     		 
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