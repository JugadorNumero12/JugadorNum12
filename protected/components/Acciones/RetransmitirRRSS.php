<?php

/** 
 * Descripcion breve: Retransmitir el encuentro por las redes sociales (RRSS)
 * Tipo: Partido
 * Perfil asociado: Ultra, Movedora
 *
 * Efectos:
 *  Aumenta el factor de partido "defensivo"
 *  Aumenta de forma inmediata el recurso animo del jugador
 */
class RetransmitirRRSS extends AccionPartSingleton
{
   /* Función a través de la cual se accederá al Singleton */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

	/* Aplicar los efectos de la accion */
	public function ejecutar($id_usuario)
	{
		  $ret =0 ; 
	      //Traer el array de efectos
	      parent::ejecutar($id_usuario);

	      //Validar usuario
	      $us = Usuarios::model()->findByPk($id_usuario);
	      if ($us === null)
	        throw new Exception("Usuario incorrecto.", 404); 
	      // Cojo el equipo del usuario
	      $equipo = $us->equipos;
	      // Modifico Los factores de ese partido
	      $ret = min($ret,Partidos::aumentar_factores($id_partido,$equipo->id_equipo,"defensivo",Efectos::$datos_acciones['RetransmitirRRSS']['defensivo']));
	      //Modifico los recursos Del usuario
	      if (Recursos::aumentar_recursos($id_usuario,"animo",Efectos::$datos_acciones['RetransmitirRRSS']['animo']) == 0)
	      {
	        $ret = min($ret,0);
	      }
	      else
	      {
	        $ret = -1;
	      }
	      //Finalizar función
	      return $ret;
	}

	/* restarurar valores tras el partido */
	public function finalizar()
	{
	}
}