<?php

/** 
 * Dar un concierto de rock
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
class ConciertoRock extends AccionGrupSingleton
{	
  /**
   * Funcion para acceder al patron Singleton
   *
   * @static
   * @return \ConciertoRock instancia de la accion
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
    //COmpruebo si la accion existe
    $accGrup = AccionesGrupales::model()->findByPk($id_accion);
    if ($accGrup === null)
      throw new Exception("Accion grupal inexistente.", 404);

    $creador = $accGrup->usuarios;
    $equipo = $creador->equipos;
    $sigPartido = $equipo->sigPartido;
    
    //1.- Añadir bonificación al partidok
    $ret = min($ret,Equipos::aumentar_recursos_equipo($equipo->id_equipo,"aforo_base",Efectos::$datos_acciones['ConciertoRock']['aforo_base']));
    //2.- Dar bonificación al creador
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"dinero",Efectos::$datos_acciones['ConciertoRock']['bonus_creador']['dinero']));
    $ret = min($ret,Recursos::aumentar_recursos($creador->id_usuario,"dinero_gen",Efectos::$datos_acciones['ConciertoRock']['bonus_creador']['dinero_gen']));
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
