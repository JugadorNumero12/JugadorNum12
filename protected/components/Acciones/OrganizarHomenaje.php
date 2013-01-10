<?php

/** 
 * Descripcion breve: Organizar un homenaje a un jugador leyenda
 * Tipo: Grupal
 * Perfil asociado: Empresario, Movedora
 *
 * Efectos:
 *  Aumenta el aforo para el proximo partido
 *
 * Bonus al creador:
 *  Aumenta en numero maximo de influencias
 */
public class OrganizarHomenaje extends AccionSingleton
{
	/* Aplicar los efectos de la accion */
	public void ejecutar($id_accion)
	{
		$trans = Yii::app()->db->beginTransaction();

      	try{
        	$helper = new Helper();
        
        	//Busco el siguiente partido (Falta seleccionar el partido actual)
        	$partido = Partidos::model()-><SELECCIONAR ENCUENTRO>;
        	
        	//Saco el nuevo aforo y se lo sumo al que había
        	$nuevoAforo = $partido->aforo + $datos_acciones['OrganizarHomenaje']['aforo'];
        	$partido->setAttributes(array('aforo'=>$nuevoAforo)); 

        	$partido->save(); 

        	//Bonus al creador: le aumento las influencias
        	$creador = AccionesGrupales::model()->findbyPK($id_accion);
   			  $helper->aumentar_recursos($creador['id_usuario'], 'influencias_max',
   				$datos_acciones['OrganizarHomenaje']['bonus_creador']['influencias_max']); 

        	$trans->commit();
      } catch {
        	$trans->rollBack();
      }
	}

	/* Restarurar valores tras el partido */
	public void finalizar($id_accion)
	{
		$trans = Yii::app()->db->beginTransaction();

      	try{
        	$helper = new Helper();

        	//Quitamos el bonus al creador
        	$creador = AccionesGrupales::model()->findbyPK($id_accion);
   			$helper->quitar_recursos($creador['id_usuario'], 'influencias_max',
   					$datos_acciones['OrganizarHomenaje']['bonus_creador']['influencias_max']); 

        	$trans->commit();
      } catch {
        	$trans->rollBack();
      }
	}
}