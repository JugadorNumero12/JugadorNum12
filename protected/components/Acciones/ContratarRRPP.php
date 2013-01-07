<?php

/** 
 * Descripcion breve: Contratar un relaciones públicas hasta el siguiente partido
 * Tipo: Individual
 * Perfil asociado: Empresario, Movedora
 *
 * Efectos:
 *  Reduce el coste de influencia de todas las acciones del jugador hasta el proximo partido
 */
public class ContratarRRPP extends AccionSingleton
{
	/* Aplicar los efectos de la accion  */
	public void ejecutar()
	{
		//Voy a modificar la base de datos asi que comienzo una tranasacción
		$trans=Yii::app()->db->beginTransaction();
	    try
	    {
	    	//Consigo el id de usuarios y los datos de sus recursos
	      $idUsuario = Yii::app()->user->usIdent;        
	      $modeloRecursos = $idUsuario->recursos;
	      //Si da fallo salimos del if (y acabamos el try)
	      if($modeloRecursos == null)
	      {
	      	break;
	      }
	      else
	      {
	      	//Si no, actualizamos los bonus actuales. 
	      	//Como esta habilidad nos hace gastar menos influencia restamos el bonus 
	      	$bonusActuales=$recursos->bonus_influencias;
			$valor_nuevo=$bonusActuales - 1;

			/*Si save() no lanza error entonces se realizo correctamente la actualizacion
			sino salimos el if (y acabamos el try)*/
			if($recursos->save())
			{
				break;
			}

	      }
	      $trans->commit();
	    }
	    catch (Exception $e)
	    {
	      $trans->rollBack();
	    }     
	}

	/* Restarurar valores tras el partido */
	public void finalizar()
	{
		//Voy a modificar la base de datos asi que comienzo una tranasacción
		$trans=Yii::app()->db->beginTransaction();
	    try
	    {
	    	//Consigo el id de usuarios y los datos de sus recursos
	      $idUsuario = Yii::app()->user->usIdent;        
	      $modeloRecursos = $idUsuario->recursos;
	      //Si da fallo salimos del if (y acabamos el try)
	      if($modeloRecursos == null)
	      {
	      	break;
	      }
	      else
	      {
	      	//Si no, actualizamos los bonus actuales. 
	      	//Como esta habilidad nos hace gastar menos influencia restamos el bonus 
	      	$bonusActuales=$recursos->bonus_influencias;
			$valor_nuevo=$bonusActuales + 1;

			/*Si save() no lanza error entonces se realizo correctamente la actualizacion
			sino salimos el if (y acabamos el try)*/
			if($recursos->save())
			{
				break;
			}

	      }
	      $trans->commit();
	    }
	    catch (Exception $e)
	    {
	      $trans->rollBack();
	    }     
	}
	}
}