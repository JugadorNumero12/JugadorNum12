<?php

/** 
 * Descripcion breve: Hablar con el speaker del partido
 * Tipo: Partido
 * Perfil asociado: Movedora
 *
 * Efectos:
 *  Aumenta el factor de partido "moral_propio"
 *  Aumenta el factor de partido "ofensivo_propio"
 */
class HablarSpeaker extends AccionPartSingleton
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
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"moral",Efectos::$datos_acciones['HablarSpeaker']['moral']));
	    $ret = min($ret,$helper->aumentar_factores($sigPartido->id_partido,$equipo->id_equipo,"ofensivo",Efectos::$datos_acciones['HablarSpeaker']['ofensivo']));

	    //Finalizar función
	    return $ret;
	}

	public function finalizar() {}
}