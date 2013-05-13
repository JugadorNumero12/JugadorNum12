<?php

/** 
 * Hackear plataforma rival 
 * 
 * Tipo : Accion grupal
 *
 * Perfil asociado : RRPP
 *
 * Efectos :
 *
 * - disminuye aforo rival para el proximo partido 
 * - disminuye el nivel del equipo contrario
 *
 * Bonus al creador
 *
 * - Recupera al instante todas las influencias que tuviese apostadas
 *
 *
 * @package componentes\acciones
 */
class HackearPlataforma extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \HackearPlataforma instancia de la accion
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
