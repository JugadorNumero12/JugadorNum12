<?php

/** 
 * Falsear cuentas
 *
 * Tipo : Individual
 *
 * Efectos
 *
 * - Reduce el coste de dinero de todas las acciones del jugador hasta el proximo partido
 *
 *
 * @package componentes\acciones
 */
class FalsearCuentas extends AccionIndSingleton
{
  /**
     * Funcion para acceder al patron Singleton
     *
     * @static
     * @return \FalsearCuentas instancia de la accion 
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
    * finalizar la accion
    *
    * @param int $id_usuario id del usuario
    * @param int $id_habilidad id de la habilidad usada
    * @return int 0 si completada con exito ; -1 en caso contrario
    */
  public function finalizar($id_usuario,$id_habilidad)
  {
        // TODO
  }

}
