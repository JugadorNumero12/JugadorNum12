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
	} 
}