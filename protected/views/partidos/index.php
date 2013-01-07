<?php
/* @var $esDeUsuario indica si el equipo del usuario juega en cada partido */
/* @var $equiposL contiene los equipos locales de cada partido */
/* @var $equiposL contiene los equipos visitantes de cada partido */
 
	$count = count($equiposL); //count($equiposL) = count($equiposV) por construccion
	for ($i = 0; $i < $count; $i++) {

			//creamos un string con el nombre de los 2 equipos concatenados con un 'vs'
			$local      = $equiposL[$i];
			$visitante  = $equiposV[$i];
			$strPartido = $local['nombre'].' vs '.$visitante['nombre'].'</br>';

			//ponemos en negrita los partidos en los que juega el equipo del usuario
			if($esDeUsuario[$i]) 
				 echo '<b>'.$strPartido.'</b>';
			else echo $strPartido;		
	} 
?>