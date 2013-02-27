<?php
/* PONER VARIABLES DEL SCRIPT */

/*
*
* ESTRUCTURA DE LA VISTA
* 1.- Un <div> que servirá para contener todas las secciones 1, 2, 3 y 4. Es 
* necesario porque Ajax lo necesita para saber qué meterá dentro. 
* IMPORTANTE: no es necesario meter ahora dentro de ese <div> las secciones
* correspondientes ya que será el renderPartial (de la vista _estadoPartido)
* el que las meta ahí. Solo hace falta que ese <div> tenga el tamaño y posición
* adecuados para contenerlas.
* IMPORTANTE: este div es el que hay abajo creado. Lo único que falta es darle un 
* ID o clase con CSS para tamaños y todo eso. No hay que meter nada más en él salvo
* la llamada que ya tiene dentro (no borrarla).

* 1.- Un <div> bajo este contenedor anterior para meter las acciones de partido.
*/
?>

<div id="envoltorio-asistir">

	<div id="renderizado-parcial">
		<?php $this->renderPartial('_estadoPartido',array('estado' => $estado)); ?>
	</div> <!--end renderizado parcial-->

	<div id="seccion5">Aqui va la seccion 5 (Las acciones)</div> <!--end seccion5 (habilidades de partido)-->

</div> <!--end envoltorio-asistir -->