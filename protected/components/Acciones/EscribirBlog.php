<?php

/** 
 * Escribir blog de opinion
 * 
 * Tipo : Pasiva
 *
 * Efectos
 *
 * - Aumenta de forma permanente el atributo <influencias_max>
 *
 *
 * @package componentes\acciones
 */
class EscribirBlog extends AccionPasSingleton
{
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \EscribirBlog instancia de la accion 
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
      // TODO
      $ret = 0;
      //Validar usuario
      $us = Usuarios::model()->findByPk($id_usuario);
      if ($us === null)
        throw new Exception("Usuario incorrecto.", 404);      

      //Aumentar animo_max
      $ret = min($ret,Recursos::aumentar_recursos($id_usuario,"influencias_max",Efectos::$datos_acciones['Ascender']['dinero_gen'])); 

      return $ret;
  }

  /**
   * Accion permanente: sin efecto en finalizar() 
   * @return void
   */
  public function finalizar() {} 

}
