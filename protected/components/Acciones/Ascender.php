<?php

/** 
 * Descripcion breve: Ascender en el trabajo
 * Tipo: Pasiva
 * Perfil asociado: Empresario, Ultra
 *
 * Efectos:
 * 	Aumenta de forma permanente la generacion de dinero
 */
class Ascender extends AccionPasSingleton
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

  /* Aplicar los efectos de la accion */
  public function ejecutar($id_usuario)
  {
    //Validar usuario
    $us = Usuarios::model()->findByPk($id_usuario);
    if ($us === null)
      throw new Exception("Usuario incorrecto.", 404);      

    //Aumentar dinero
    $helper = new Helper();
    if (Recursos::aumentar_recursos($id_usuario,"dinero_gen",Efectos::$datos_acciones['Ascender']['dinero_gen']) == 0)
    {
      return 0;
    }
    else
    {
      return -1;
    }  
  }

  /* Accion permanente: metodo vacio */
  public function finalizar() 
  { 
  }	
}