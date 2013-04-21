<?php

/** 
 * Ascender en el trabajo
 * 
 * Tipo
 *
 * - Pasiva
 * 
 * Perfiles asociados
 *
 * - Empresario
 * - Ultra
 *
 * Efectos
 *
 * - Aumenta de forma permanente la generacion de dinero
 *
 *
 * @package componentes\acciones
 */
class Ascender extends AccionPasSingleton
{
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \Ascender instancia de la accion 
   */
  public static function getInstance()
  {
      if (!self::$instancia instanceof self) {
         self::$instancia = new self;
      }
      return self::$instancia;
  }

  /**
   * Ejecutar la accion
   *
   * @param int $id_usuario id del usuario que realiza la accion
   * @throws \Exception usuario no encontrado
   * @return int 0 si completada con exito ; -1 en caso contrario
   */
  public function ejecutar($id_usuario)
  {
    //Validar usuario
    $us = Usuarios::model()->findByPk($id_usuario);
    if ($us === null)
      throw new Exception("Usuario incorrecto.", 404);      

    //Aumentar dinero
    $helper = new Helper();
    if (Recursos::aumentar_recursos($id_usuario,"dinero_gen",Efectos::$datos_acciones['Ascender']['dinero_gen']) == 0) {
      return 0;
    } else {
      return -1;
    }  
  }

  /**
   * Accion permanente: sin efecto en finalizar() 
   * @return void
   */
  public function finalizar() 
  { 
  }	

}
