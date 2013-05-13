<?php

/** 
 * Construir un estadio nuevo
 * 
 * Tipo : Accion grupal
 * 
 * Efectos :
 *
 * - aumenta el aforo maximo del equipo
 * - aumenta la moral de todos los miembros del equipo
 * - aumenta el nivel del equipo
 *
 * Bonus al creador :
 * 
 * Ninguno
 *
 *
 * @package componentes\acciones
 */
class ConstruirEstadio extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \ConstruirEstadio instancia de la accion
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
  public function ejecutar($id_accion)
  {
    // TODO
    
    $ret = 0;

    //1.- Añadir bonificación al partido

    //2.- Dar bonificación al creador

    //3.- Devolver influencias

    //4.- Finalizar función

    return $ret;
  }

  /**
   * Accion grupal: sin efecto en finalizar()
   * @return void
   */
  public function finalizar() {}

}
