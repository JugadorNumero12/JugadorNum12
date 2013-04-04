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
<script>
	var myVar = setInterval(function(){actPartido()},3000);

	function actPartido()
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function()
		{
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				<?php if ($estado->turno > 0 && $estado->turno < 12)
				{
					echo 'document.getElementById("renderizado-parcial").innerHTML = xmlhttp.responseText;';	
					echo 'abc();';
				}
				?>
			}
		}
		<?php if ($estado->turno > 0 && $estado->turno < 12)
		{
			echo 'xmlhttp.open("GET","http://localhost'.Yii::app()->createUrl('partidos/actpartido',array('id_partido' => $estado->id_partido)).'",true);
					xmlhttp.send();';	
		}
		?>
		
	}
</script>	
<script type="text/javascript">
</script>

	 <div id="seccion1"> 

	 	<div id="estadisticas">

			<h2>Estad&iacute;sticas visitante visitante</h2> 
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

		</div> <!--end estadisticas-->

		<div class="chart">
	        <div class="percentage" data-percent="<?php echo $porcentage ?>"><span><?php echo $estado->estado?></span></div>
	        <div class="label">Estado</div>
        </div> <!--end chart-->

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
		
		<div class="label-marcador"> <p>Local&nbsp;&nbsp;<?php echo $estado->goles_local?>&nbsp;&nbsp;</p></div>

		 <?php /*switch ($nombre_local)
			{
			case 'Rojos': ?>
			  	<img title="El equipo local lleva <?php echo $estado->goles_local ?> goles", class="escudos-marcador"  src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-rojo.png'; ?>" width="50px" height="50px" alt="Rojos">
				<?php break;
			case 'Verdes':?>
			  	<img title="El equipo local lleva <?php echo $estado->goles_local ?> goles", class="escudos-marcador"  src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-verde.png'; ?>"  width="50px" height="50px" alt="Verdes">								  
				<?php break;
			case 'Negros':?>
			  	<img title="El equipo local lleva <?php echo $estado->goles_local ?> goles", class="escudos-marcador"  src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-negro.png'; ?>"  width="50px" height="50px" alt="Negros">
				<?php break;
			case 'Blancos':?>				
			  	<img title="El equipo local lleva <?php echo $estado->goles_local ?> goles", class="escudos-marcador" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-blanco.png'; ?>"  width="50px" height="50px" alt="Blancos">
				<?php break;
			}*/ ?>
		<img
		title="<?php echo $equipoLocal->nombre; ?>",
		class="escudos-marcador"
		src="<?php echo Yii::app()->BaseUrl . '/images/escudos/40px/' . $equipoLocal->token . '.png'; ?>"
		alt="<?php echo $equipoLocal->nombre; ?>"
		width="40" height="40" />

		<div class="label-marcador"> <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visitante&nbsp;&nbsp;<?php echo $estado->goles_visitante?>&nbsp;&nbsp;</p> </div>


		 <?php /*switch ($nombre_visitante)
			{
			case 'Rojos': ?>
			  	<img title="El equipo visitante lleva <?php echo $estado->goles_visitante ?> goles", class="escudos-marcador" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-rojo.png'; ?>" width="50px" height="50px" alt="Rojos">
				<?php break;
			case 'Verdes':?>
			  	<img title="El equipo visitante lleva <?php echo $estado->goles_visitante ?> goles", class="escudos-marcador" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-verde.png'; ?>"  width="50px" height="50px" alt="Verdes">								  
				<?php break;
			case 'Negros':?>
			  	<img title="El equipo visitante lleva <?php echo $estado->goles_visitante ?> goles", class="escudos-marcador"  src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-negro.png'; ?>"  width="50px" height="50px" alt="Negros">
				<?php break;
			case 'Blancos':?>				
			  	<img title="El equipo visitante lleva <?php echo $estado->goles_visitante ?> goles", class="escudos-marcador"  src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-blanco.png'; ?>"  width="50px" height="50px" alt="Blancos">
				<?php break;
			}*/ ?>
		<img
		title="<?php echo $equipoVisitante->nombre; ?>",
		class="escudos-marcador"
		src="<?php echo Yii::app()->BaseUrl . '/images/escudos/40px/' . $equipoVisitante->token . '.png'; ?>"
		alt="<?php echo $equipoVisitante->nombre; ?>"
		width="40" height="40" />

	</div> <!--end seccion3 (marcador)-->

	<div id="seccion4">
		<h2> Cr&oacute;nica </h2> <br>
		<?php echo nl2br($estado->cronica)?>
	</div> <!--end seccion4 (cronica)-->

</div> <!--end envoltorio_estadoPartido -->

