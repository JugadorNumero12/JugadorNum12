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
  /* Función a través de la cual se accederá al Singleton */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

  /* Ningun efecto al ejecutar la accion */
  public function ejecutar($id_usuario)
  {
    //Traer el array de efectos
    parent::ejecutar($id_usuario);

    //Validar usuario
    $us = Usuarios::model()->findByPk($id_usuario);
    if ($us === null)
      throw new Exception("Usuario incorrecto.", 404);      

    //Aumentar ánimo
    if (Recursos::aumentar_recursos($id_usuario,"dinero",Efectos::$datos_acciones['Apostar']['dinero']) == 0)
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