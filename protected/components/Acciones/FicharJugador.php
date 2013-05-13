<?php

/** 
 * Fichar jugador
 * 
 * Tipo : Accion grupal
 *
 * Perfil asociado : Empresario
 *
 * Efectos :
 *
 * - aumenta el aforo base del equipo
 * - aumenta el nivel del equipo
 * - aumenta el aforo para el proximo partido
 *
 * Bonus al creador :
 *
 * Aumenta el recurso <influencias_max>
 *
 *
 * @package componentes\acciones
 */
class FicharJugador extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \FicharJugador instancia de la accion
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
