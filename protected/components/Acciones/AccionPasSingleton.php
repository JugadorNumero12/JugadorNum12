<?php 
class AccionPasSingleton
{
   /* Instancia del objeto */
   private static $instancia;   

   /* Incluir tabla de efectos */
   include('tabla_efectos.php');

   /* Constructora privada para evitar instanciación externa */
   private function __construct()
   {
      echo "Creado singletonDeAccionIndividual"; //Eliminar!!
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
   public function ejecutar($id_usuario){ }

   public function finalizar() { }

   /* Evita que el objeto se pueda clonar */
   public function __clone()
   {
      trigger_error('Clonación no permitida.', E_USER_ERROR);
   } 
}
?>