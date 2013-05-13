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
  }

  /**
   * Accion permanente: sin efecto en finalizar() 
   * @return void
   */
  public function finalizar() {} 

}
