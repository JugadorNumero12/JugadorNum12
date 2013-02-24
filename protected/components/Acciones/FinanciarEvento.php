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
public class FinanciarEvento extends AccionGrupSingleton
{	
  /* Aplicar los efectos de la accion */
  public function ejecutar($id_accion)
  {
    $ret = 0;

    $accGrup = AccionesGrupales::model()->findByPk($id_accion);
    if ($accGrup == null)
      throw new Exception("Accion grupal inexistente.", 404);
      
    $creador = $accGrup->usuarios;
    $sigPartido = $creador->equipos->sigPartido;

    //1.- Añadir bonificación al partido
    //Saco el ambiente nuevo y se lo añado
    $nuevoAmbiente = $sigPartido->ambiente + $datos_acciones['FinanciarEvento']['ambiente'];
    $sigPartido->setAttributes(array('ambiente'=>$nuevoAmbiente));  
    //Saco el aforo y se lo añado
    $nuevoAforo = $sigPartido->aforo + $datos['FinanciarEvento']['aforo'];
    $sigPartido->setAttributes(array('aforo'=>$nuevoAforo));  

    ($sigPartido->save())? $ret = 0: $ret = -1;

    //2.- Dar bonificación al creador

    //3.- Devolver influencias

    //Tomar helper para facilitar la modificación
    Yii::import('application.components.Helper');

    $participantes = $accGrup->participaciones;
    foreach ($participaciones as $participacion)
    {
      $infAportadas = $participacion->influencas_aportadas;
      $usuario = $participacion->usuarios_id_usuario;
      if ($helper->aumentar_recursos($usuario,"influencias",$infAportadas) == 0)
      {
        $ret = min($res,0);
      }
      else
      {
        $ret = -1;
      }
    }

    //Finalizar función
    return $ret;
  }

  /* Restaurar valores tras el partido. NO ES NECESARIO YA. */
  public function finalizar()
  {
  }	
}