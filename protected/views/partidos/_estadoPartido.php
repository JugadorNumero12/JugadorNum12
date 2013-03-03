<?php
/* @var $estado -> Incluye los datos de la fila correspondiente de "Partidos" */
	//Estado es un modelo de partidos

/*
*
* Mostrar en este apartado las secciones 1, 2, 3 y 4
*
*/
?>

<div id="envoltorio_estadoPartido"> 

	 <div id="seccion1"> 

		<h2>Estad&iacute;sticas local visitante</h2> 
		<table>
			<tr> <th> </th> <th> Local</th> <th> Visitante </th>  </tr>
			<tr> <th> Nombre </th> <td> <?php  echo $nombre_local?></td> <td> <?php  echo $nombre_visitante?> </td>  </tr>
			<tr> <th> Nivel </th> <td> <?php  echo $estado->nivel_local?></td> <td> <?php  echo $estado->nivel_visitante?> </td>  </tr>
			<tr> <th> Aforo </th> <td> <?php  echo $estado->aforo_local?></td> <td> <?php  echo $estado->aforo_visitante?></td>  </tr>
			<tr> <th> Moral </th> <td> <?php  echo $estado->moral_local?></td> <td> <?php  echo $estado->moral_visitante?> </td>  </tr>
			<tr> <th> Ofensivo </th> <td> <?php  echo $estado->ofensivo_local?></td> <td> <?php  echo $estado->ofensivo_visitante?> </td>  </tr>
			<tr> <th> Defensivo </th> <td> <?php  echo $estado->defensivo_local?> </td> <td> <?php  echo $estado->defensivo_visitante?> </td>  </tr>
		</table>

		<br> <h2>Otros factores</h2> 
		<table>
			<tr> <th> Ambiente</th> <td> <?php  echo $estado->ambiente?></td> </tr>
			<tr> <th> Diferencia de niveles</th> <td> <?php  echo $estado->dif_niveles?> </td> </tr>
		</table>


	</div> <!--end seccion 1 (el partido)-->

	<div id="seccion2"> 
		<?php switch ($estado->turno)
			{
			case 0: ?>
			  El partido aun no ha empezado. 
			  <?php break;
			case 6:?>
			  Descanso.
			  <?php break; 
			case 12:?>
			  Fin del partido. 
			  <?php break;
			default:?>
				Estamos en el turno <?php echo $estado->turno?> del partido  
			<?php } ?>

		
	</div> <!--end seccion2 (turno en el que estamos)-->

	<div id="seccion3"> 
		Goles<br> <?php  echo $nombre_local?> Local: <?php  echo $estado->goles_local?> <?php  echo $nombre_visitante?> Visitante: <?php  echo $estado->goles_visitante?>
	</div> <!--end seccion3 (marcador)-->

	<div id="seccion4">
		<h2> Cr&oacute;nica </h2> <br>
		<?php echo nl2br($estado->cronica)?>
	</div> <!--end seccion4 (cronica)-->

</div> <!--end envoltorio_estadoPartido -->

