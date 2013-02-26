<?php

/** 
 * Descripcion breve: Apostar resultado del proximo partido
 * Tipo: Individual
 * Perfil asociado: Empresario, Ultra
 *
 * Efectos
 *  aumenta el dinero al acabar el partido (de momento para cualquier resultado)
 */
class Apostar extends AccionIndSingleton
{
  /* Ningun efecto al ejecutar la accion */
  public function ejecutar($id_usuario)
  {
    //Validar usuario
    $us = Usuarios::model()->findByPk($id_usuario);
    if ($us == null)
      throw new Exception("Usuario incorrecto.", 404);      

    //Tomar helper para facilitar la modificación
    Yii::import('application.components.Helper');

    //Aumentar ánimo
    $helper = new Helper();
    if ($helper->aumentar_recursos($id_usuario,"dinero",$datos_acciones['Apostar']['dinero']) == 0)
    {
      return 0;
    }
    else
    {
      return -1;
    }
  }

  /* Aplicar la bonificacion al acabar el partido */
  public function finalizar($id_usuario,$id_habilidad)
  {
    //Validar parámetros y devolver influencias
    $res = parent::finalizar($id_usuario,$id_habilidad);
    return $res;
  }	
}