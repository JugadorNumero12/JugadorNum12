<?php
/* Accion grupal */
public class Pintarse extends AccionSingleton
{
	
   /* Todos los participantes reciben inmediatamente un extra al animo
    *  el usuario que inicio la accion recibe un bonus
    */
   public function ejecutar($id_accion)
   {
   		$helper = new Helper();
		
   		/* Usuarios que participaron */
   		$participantes = Participantes::model()->findbyPK($id_accion);

   		/* aumentar el animo de cada participante */
   		foreach ($participantes as $participante)
		{
			$helper->aumentar_recursos($participante["id_usuario"], "animo", 30);
		}

   		/* Usuario que la inicio */
   		$creador = AccionesGrupales::model()->findbyPK($id_accion); //...
   		$helper->aumentar_recursos($creador["id_usuario"], "animo", 10);
   }

   /* Codigo asociado a finalizar dicha acción. P. ej.: devolver X influencias al jugador. */
   public function finalizar()
   {
   
   }	
}
?>