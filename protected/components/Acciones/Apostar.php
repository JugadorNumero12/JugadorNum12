<?php

/** 
 * Apostar resultado del proximo partido
 *
 * Tipo
 * 
 * - Individual
 * 
 * Perfiles asociados
 *
 * - Empresario
 * - Ultra
 *
 * Efectos
 * 
 * - aumenta el dinero al acabar el partido (de momento para cualquier resultado)
 *
 *
 * @package componentes\acciones
 */
class Apostar extends AccionIndSingleton
{
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \Apostar instancia de la accion
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
    //Traer el array de efectos
    parent::ejecutar($id_usuario);

    //Validar usuario
    $us = Usuarios::model()->findByPk($id_usuario);
    if ($us === null)
      throw new Exception("Usuario incorrecto.", 404);      

    //Aumentar ánimo
    if (Recursos::aumentar_recursos($id_usuario,"dinero",Efectos::$datos_acciones['Apostar']['dinero']) == 0) {
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
    $res = parent::finalizar($id_usuario,$id_habilidad);
    return $res;
  }

}
