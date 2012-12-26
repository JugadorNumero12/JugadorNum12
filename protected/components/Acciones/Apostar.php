<?php

/** 
 * Descripcion breve: Apostar resultado del proximo partido
 * Tipo: Individual
 * Perfil asociado: Empresario, Ultra
 *
 * Efectos
 *  aumenta el dinero al acabar el partido (de momento para cualquier resultado)
 */
public class Apostar extends AccionSingleton
{
  /* Ningun efecto al ejecutar la accion */
  public function ejecutar($id_accion)
  {
  	/* VACIO */
  }

  /* Aplicar la bonificacion al acabar el partido */
  public function finalizar()
  {
  	/* TODO */
  }	
}