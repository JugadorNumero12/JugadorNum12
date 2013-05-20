<?php

/** 
 * Mandar a un jugador rival al hospital
 *
 * Tipo : Accion grupal
 * 
 * Efectos :
 *
 * - reduce el nivel del equipo contrario
 *
 * Bonus al creador :
 * 
 * - ninguno
 *
 *
 * @package componentes\acciones
 */
class MandarJugadorHospital extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \MandarJugadorHospital instancia de la accion
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
    //COmpruebo si la accion existe
    $accGrup = AccionesGrupales::model()->findByPk($id_accion);
    if ($accGrup === null)
      throw new Exception("Accion grupal inexistente.", 404);

    $creador = $accGrup->usuarios;
    $equipo = $creador->equipos;
    $sigPartido = $equipo->sigPartido;

    //1.- Añadir bonificación al partido
    $ret = min($ret,Partidos::disminuir_factores($sigPartido->id_partido,$equipo->id_equipo,"nivel",Efectos::$datos_acciones['MandarJugadorHospital']['nivel_equipo']));
    
    //3.- Devolver influencias
    $participantes = $accGrup->participaciones;
    foreach ($participantes as $participacion) {
      $infAportadas = $participacion->influencias_aportadas;
      $usuario = $participacion->usuarios_id_usuario;
      //if (Recursos::aumentar_recursos($usuario,"influencias",$infAportadas) == 0) {
      if(Recursos::disminuir_influencias_bloqueadas($usuario,$infAportadas) == 0){
        $ret = min($ret,0);
      } else {
        $ret = -1;
      }
    }
    //4.- Finalizar funciónK
    return $ret;
  }

  /**
   * Accion grupal: sin efecto en finalizar()
   * @return void
   */
  public function finalizar() {}

}
