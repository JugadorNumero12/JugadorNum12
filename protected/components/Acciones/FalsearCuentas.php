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

        //Traer el array de efectos
        parent::ejecutar($id_usuario);

        //Validar usuario
        $us = Usuarios::model()->findByPk($id_usuario);
        if ($us === null)
          throw new Exception("Usuario incorrecto.", 404);  

        if (Recursos::aumentar_recursos($id_usuario,"bonus_dinero",Efectos::$datos_acciones['FalsearCuentas']['bonus_jugador']['dinero']) == 0) {
          return 0;
        } else {
          return -1;
        }
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
    $res = parent::finalizar($id_usuario,$id_habilidad);

    //Restablecer bonus_influencias
    if (Recursos::quitar_recursos($id_usuario,"bonus_dinero",Efectos::$datos_acciones['ContratarRRPP']['bonus_jugador']['influencias']) == 0) {
      return min($res,0);
    } else {
      return -1;
    }
  }

}
