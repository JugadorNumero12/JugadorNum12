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
		<?php $this->renderPartial('_estadoPartido',array('nombre_local'=> $nombre_local,
								 'nombre_visitante' => $nombre_visitante,
								 'estado' => $estado)); ?>
	</div> <!--end renderizado parcial-->


	<div id="seccion5">
		Aqui va la seccion 5 (Las acciones)
		<br>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dictum euismod risus, in imperdiet velit pharetra sed. Donec iaculis massa nec dui dignissim pellentesque. Etiam nec sem enim, et ullamcorper tortor. Vestibulum vitae sem id purus sagittis mattis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras ullamcorper magna condimentum velit viverra sed tincidunt nulla bibendum. Nam sed massa ac massa tempor aliquam nec ut eros. Quisque et diam eget erat ornare ultricies.

Nam fringilla mauris sit amet justo lacinia porta. Pellentesque nec tortor quam, ac hendrerit purus. Quisque non nisl dui, in dapibus nunc. Quisque pretium nulla id nibh posuere mattis. Aenean luctus libero nec nibh euismod viverra. Curabitur imperdiet nisl vitae sapien dictum posuere. Aliquam non tristique lorem. Suspendisse placerat ante molestie libero pulvinar dictum. Suspendisse ultrices cursus hendrerit. Nulla a mauris ut urna mollis ullamcorper eu eget lorem.
	</div> <!--end seccion5 (habilidades de partido)-->

</div>
