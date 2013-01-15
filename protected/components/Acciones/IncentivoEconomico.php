<?php

/** 
 * Descripcion breve: Incentivar economicamente a los jugadores
 * Tipo: Grupal
 * Perfil asociado: Empresario
 *
 * Efectos:
 *  Aumenta hasta el proximo partido el factor de partido "nivel_equipo"
 *
 * Bonus al creador:
 *  Recupera de forma inmediata influencias empleadas en otras acciones
 */
public class IncentivoEconomico extends AccionSingleton
{
	
	/* Aplicar los efectos de la accion */
	public void ejecutar()
	{
		/* SAM */
		 $trans=Yii::app()->db->beginTransaction();
		 try {
		 	$helper = new Helper();

		 	//Aumentar nivel_equipo
        	$id_partido = Partidos::model()-><SELECCIONAR ENCUENTRO>;
        	$id_equipo = Yii::app()->user->usAfic;
        	$columna = 'nivel';
        	//La cantidad no creo que sea esta
        	$cantidad = $datos_acciones['IncentivoEconomico']['nivel_equipo'];
        	$helper->aumentar_factores($id_partido,$id_equipo,$columna,$cantidad);

        	//Bonus creador
        	$creador = AccionesGrupales::model()->findByPk($id_equipo);
        	//La cantidad no creo que sea esta
        	$cantidad = $datos_acciones['IncentivoEconomico']['bonus_creador']['influencias'];
        	$helper->aumentar_recursos($creador['id_usuario'],'influencias',$cantidad);

		 	$trans->commit();
		 	
		 } catch (Exception $e) {
		 	$trans->rollBack();
		 }
	}

	/* restarurar valores tras el partido */
	public void finalizar()
	{
		/* SAM */
		$trans=Yii::app()->db->beginTransaction();
		 try {
		 	$helper = new Helper();

		 	//Aumentar nivel_equipo
        	$id_partido = Partidos::model()-><SELECCIONAR ENCUENTRO>;
        	$id_equipo = Yii::app()->user->usAfic;
        	$columna = 'nivel';
        	//La cantidad no creo que sea esta
        	$cantidad = $datos_acciones['IncentivoEconomico']['nivel_equipo'];
        	$helper->disminuir_factores($id_partido,$id_equipo,$columna,$cantidad);

		 	$trans->commit();
		 	
		 } catch (Exception $e) {
		 	$trans->rollBack();
		 }
	}
}