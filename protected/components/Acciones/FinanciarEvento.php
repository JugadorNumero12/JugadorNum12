<?php

/** 
 * Descripcion breve: Financiar evento promocional
 * Tipo: Accion grupal
 * Perfil asociado: Empresario
 *
 * Efectos
 * 	 aumenta aforo para el proximo partido 
 *	 aumenta ambiente para el procimo partido
 *
 * Bonus al creador
 * 	 ninguno
 */
public class FinanciarEvento extends AccionSingleton
{	
  /* Aplicar los efectos de la accion */
  public function ejecutar($id_accion)
  {
  	/* TODO */
  }

  /* Restaurar valores tras el partido */
  public function finalizar()
  {
  	/* TODO */
  }	
}