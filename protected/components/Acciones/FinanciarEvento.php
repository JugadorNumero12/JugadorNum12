<?php

/** 
 * Financiar evento promocional
 * 
 * Tipo
 * 
 * - Accion grupal
 * 
 * Perfiles asociados
 * - Empresario
 *
 * Efectos
 *
 * - aumenta aforo para el proximo partido 
 * - aumenta ambiente para el proximo partido
 *
 * Bonus al creador
 *
 * - ninguno
 *
 *
 * @package componentes\acciones
 */
class FinanciarEvento extends AccionGrupSingleton
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
  public function ejecutar($id_accion)
  {
    $ret = 0;

    $accGrup = AccionesGrupales::model()->findByPk($id_accion);
    if ($accGrup === null)
      throw new Exception("Accion grupal inexistente.", 404);
      
    $creador = $accGrup->usuarios;
    $equipo = $creador->equipos;
    $sigPartido = $equipo->sigPartido;

    //1.- Añadir bonificación al partido
    $ret = min($ret,Partidos::aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ambiente",Efectos::$datos_acciones['FinanciarEvento']['ambiente']));
    $ret = min($ret,Partidos::aumentar_factores_prop($sigPartido->id_partido,$equipo->id_equipo,"aforo",Efectos::$datos_acciones['FinanciarEvento']['aforo']));
    $ret = min($ret,Partidos::aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"moral",Efectos::$datos_acciones['FinanciarEvento']['moral']));

    //2.- Dar bonificación al creador

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

    //Finalizar función
    return $ret;
  }

  /**
   * Accion grupal: sin efecto en finalizar()
   * @return void
   */
  public function finalizar() {}

}
