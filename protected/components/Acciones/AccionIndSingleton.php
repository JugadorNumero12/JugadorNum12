<?php 
class AccionIndSingleton
{
   /* Instancia del objeto */
   private static $instancia;   

   /* Constructora privada para evitar instanciación externa */
   private function __construct()
   {
      //echo "Creado singletonDeAccionIndividual";
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
      /* Incluir tabla de efectos */
      Yii::import('application.components.acciones.tabla_efectos.php');
   }

   /* Codigo asociado a finalizar dicha acción. P. ej.: devolver X influencias al jugador. */
   public function finalizar($id_usuario,$id_habilidad)
   {      
      /* Incluir tabla de efectos */
      Yii::import('application.components.acciones.tabla_efectos.php');

      //Validar usuario
      $us = Usuarios::model()->findByPk($id_usuario);
      if ($us === null)
         throw new Exception("Usuario incorrecto.", 404); 

      //Tomar y validar habilidad
      $hab = Habilidades::model()->findByPk($id_habilidad); 
      if ($hab === null)
         throw new Exception("Habilidad incorrecta.", 404); 
      //Coger influencias a devolver
      $influencias = $hab->influencias;   

      //Tomar helper para facilitar la modificación
      Yii::import('application.components.Helper');

      //Aumentar ánimo
      $helper = new Helper();
      if ($helper->aumentar_recursos($id_usuario,"influencias",$influencias) == 0)
      {
         return 0;
      }
      else
      {
         return -1;
      }
   }

   /* Evita que el objeto se pueda clonar */
   public function __clone()
   {
      trigger_error('Clonación no permitida.', E_USER_ERROR);
   } 
}
?>