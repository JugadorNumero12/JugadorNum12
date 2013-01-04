<?php
public class Helper 
{
	public Helper(){}

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que aumentamos
	 * @devuelve flag de error
	 * @ejemplo	$h->aumentar_recursos(3, "animo", 30);
	 */
	public int aumentar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuario::model()->findByPK($id_usuario);
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$valor_nuevo=$actuales + $cantidad;
				/*Debo comprobar que no esta o sobrepasa en su máximo el atributo*/

				/*En el caso del animo*/
				if( ($columna==='animo') && ($valor_nuevo >= $recursos->animo_max))
				{
					$recursos->$columna=$recursos->animo_max;

				}else if( ($columna==='influencias') && ($valor_nuevo >= $recursos->influencias_max))
						{
							$recursos->$columna=$recursos->influencias_max;

						}else 
							{
								$recursos->$columna=$valor_nuevo;
							}
				
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
		
	}

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que quitamos
	 * @devuelve flag de error
	 * @ejemplo	$h->quitar_recursos(3, "animo", 30);
	 */
	public int quitar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuario::model()->findByPK($id_usuario);
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$recursos->$columna=$actuales - $cantidad;
				/*Al restar debo de comprobar que no sea valor negativo*/
				if($recursos->$columna < 0)
				{
					$recursos->$columna=0;
				}
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
	} 
}