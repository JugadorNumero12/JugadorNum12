<?php

/** 
 * Financiar pelicula
 * 
 * Tipo : Accion grupal
 *
 * Perfil asociado : Empresario
 *
 * Efectos :
 *
 * - aumenta el aforo base del equipo
 * - aumenta el nivel del equipo
 *
 * Bonus al creador :
 *
 * Aumenta el recurso <animo_gen>
 * Aumenta el atributo <dinero_gen>
 *
 *
 * @package componentes\acciones
 */
class FinanciarPelicula extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \FinanciarPelicula instancia de la accion
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
    $ret = min($ret,Equipos::aumentar_recursos_equipo($equipo->id_equipo,"aforo_base",Efectos::$datos_acciones['FinanciarPelicula']['aforo_base']));
    $ret = min($ret,Partidos::aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"nivel",Efectos::$datos_acciones['FinanciarPelicula']['nivel_equipo']));
    //2.- Dar bonificación al creador
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"animo_gen",Efectos::$datos_acciones['FinanciarPelicula']['bonus_creador']['animo_gen']));
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"dinero_gen",Efectos::$datos_acciones['FinanciarPelicula']['bonus_creador']['dinero_gen']));
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
