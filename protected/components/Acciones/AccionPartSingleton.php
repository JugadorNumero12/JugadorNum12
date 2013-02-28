<?php 
class AccionPartSingleton
{
   /* Instancia del objeto */
   private static $instancia;   

   /* Constructora privada para evitar instanciación externa */
   private function __construct()
   {
      echo "Creado singletonDeAccionDePartido"; //Eliminar!!
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

   /* Codigo asociado a ejecutar dicha acción. P. ej.: dar X de ánimo al jugador. 
   Tambien devuelve las influencias aportadas.
   Se llamará al crear una grupal o participar en ella, siempre y cuando los recursos hayan sido alcanzados. */
   public function ejecutar($id_usuario)
   {
      /* Incluir tabla de efectos */
      Yii::import('application.components.acciones.tabla_efectos.php');
   }

   public function finalizar() 
   {
      /* Incluir tabla de efectos */
      Yii::import('application.components.acciones.tabla_efectos.php');
   }

   /* Evita que el objeto se pueda clonar */
   public function __clone()
   {
      trigger_error('Clonación no permitida.', E_USER_ERROR);
   } 
}
?>