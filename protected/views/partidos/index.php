
<?php
/* @var $esDeUsuario indica si el equipo del usuario juega en cada partido */
/* @var $equiposL contiene los equipos locales de cada partido */
/* @var $equiposL contiene los equipos visitantes de cada partido */
/* @var $idPartidos los id de los partidos en los que participa el equipo del usuario */
 
/*	$count = count($equiposL); //count($equiposL) = count($equiposV) por construccion
	for ($i = 0; $i < $count; $i++) {

			//creamos un string con el nombre de los 2 equipos concatenados con un 'vs'
			$local      = $equiposL[$i];
			$visitante  = $equiposV[$i];
			$strPartido = $local['nombre'].' vs '.$visitante['nombre'].'</br>'; 

			if($esDeUsuario[$i]) 
			{ 
				 echo '<b>'.$strPartido.'</b>';
			}
			else
			{ 
				echo $strPartido;		
			}
	} */
?>


<table cellspacing="5px">
	<?php 
	$count = count($equiposL);
	for ($i = 0; $i < $count; $i++) { 

		//creamos un string con el nombre de los 2 equipos concatenados con un 'vs'
		$local      = $equiposL[$i];
		$visitante  = $equiposV[$i];
		$strPartido = $local['nombre'].' vs '.$visitante['nombre'].'</br>'; 
		?>
	<tr>
		<td align="center"> <a href=
									"<?php echo $this->createUrl( '/partidos/previa', 
									array('id_partido' => $idPartidos[$i]) ); ?>">  

							<?php if($esDeUsuario[$i]) 
									{ 
										 echo '<b>'.$strPartido.'</b>';
									}
									else
									{ 
										echo $strPartido;		
									} ?></td>
							</a>
	</tr>
	<?php } ?>
	<tr></tr>
</table>