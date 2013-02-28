<?php 
class AccionPasSingleton
{
   /* Instancia del objeto */
   protected static $instancia;   

   /* Constructora privada para evitar instanciación externa */
   protected function __construct()
   {
      //echo "Creado singletonDeAccionPasiva";
   }

   /* Función a través de la cual se accederá al Singleton */
   public static function getInstance()
   {
      if (!self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }

   /* Codigo asociado a ejecutar dicha acción. P. ej.: dar X de ánimo al jugador. */
   public function ejecutar($id_usuario)
   {
   }

   public function finalizar() 
   {
   }

   /* Evita que el objeto se pueda clonar */
   public function __clone()
   {
      trigger_error('Clonación no permitida.', E_USER_ERROR);
   } 
}
?>