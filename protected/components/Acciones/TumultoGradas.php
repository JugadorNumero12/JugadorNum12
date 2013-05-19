<?php

/** 
 * Descripcion breve: Pelea entre aficiones en la grada
 * Tipo: Partido
 *
 * Efectos:
 *  Aumenta el factor ofensivo
 *  Aumenta el ambiente
 */
class TumultoGradas extends AccionPartSingleton
{
   /**
    * Acceso al patron Singleton
    * @static
    * @return void
    */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self) {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

	/**
	 * Aplicar los efectos de la accion
	 * @return void
	 */
	public function ejecutar($id_usuario,$id_partido,$id_equipo)
	{
		// TODO
	}

	/** Accion de partido : Sin efecto en finalizar */
	public function finalizar(){ }

}