<?php

/** 
 * Financiar videojuego
 * 
 * Tipo : Accion grupal
 *
 * Perfil asociado : Empresario
 *
 * Efectos :
 *
 * - aumenta el aforo base del equipo
 *
 * Bonus al creador :
 *
 * Aumenta el recurso <dinero>
 * Aumenta el atributo <dinero_gen>
 *
 *
 * @package componentes\acciones
 */
class FinanciarVideojuego extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \FinanciarVideojuego instancia de la accion
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
    //1.- Añadir bonificación al partidok
    $ret = min($ret,Partidos::aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",Efectos::$datos_acciones['FinanciarEvento']['ambiente']));
    //2.- Dar bonificación al creador
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"influencias",Efectos::$datos_acciones['IncentivoEconomico']['bonus_creador']['influencias']));
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"influencias",Efectos::$datos_acciones['IncentivoEconomico']['bonus_creador']['influencias']));
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
