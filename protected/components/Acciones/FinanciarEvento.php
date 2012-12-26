<?php

/** 
 * Descripcion breve: Financiar evento promocional
 * Tipo: Accion grupal
 * Perfil asociado: Empresario
 *
 * Efectos:
 * 	 Aforo, 	nivel medio
 *	 Ambiente,  nivel bajo
 *
 * Bonus al creador:
 * 	 Ninguno
 */
public class FinanciarEvento extends AccionSingleton
{
	
   /* Mejoras para el proximo partido
    * 	Aforo: +0.3% 
    * 	Ambiente: +2 puntos
    */
   public function ejecutar($id_accion)
   {
   	/* TODO */
   }

   /* Restaurar valores tras el partido
    * 	Aforo: -0.3%
    *	Ambiente: -2 puntos
    */
   public function finalizar()
   {
   	/* TODO */
   }	
}