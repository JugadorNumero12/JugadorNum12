<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<?php 
	$count = count($equiposL); //count($equiposL) = count($equiposV) por construccion
	for ($i = 0; $i < $count; $i++) {
			$local     = $equiposL[$i];
			$visitante = $equiposV[$i];
			echo $local['nombre'].' vs '.$visitante['nombre'].'</br>';		
	} 
?>