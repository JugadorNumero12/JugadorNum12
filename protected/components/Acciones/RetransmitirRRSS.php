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
class RetransmitirRRSS extends AccionSingleton
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
		//Tomar helper para facilitar la modificación
	    Yii::import('application.components.Helper');

	    $ret = 0;

	    $creador = Usuarios::model()->findByPk($id_usuario);
	    if ($creador === null)
	      throw new Exception("Usuario inexistente.", 404);
	      
	    $equipo = $creador->equipos;
	    $sigPartido = $equipo->sigPartido;

	    //1.- Añadir bonificación al partido
	    $helper = new Helper();
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"defensivo",Efectos::$datos_acciones['RetransmitirRRSS']['defensivo']));
	   
	    //2.- Dar recursos al creador
	    $ret = min($ret,$helper->aumentar_recursos($id_usuario,"animo",Efectos::$datos_acciones['RetransmitirRRSS']['animo']));

	    //Finalizar función
	    return $ret;
	}

	/* restarurar valores tras el partido */
	public function finalizar()
	{
	}
}