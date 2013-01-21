<?php
/* @var habilidad La habilidad (acción) que se está intentando usar y toda su info */
?>

<?php 
	if ( $habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL ) {
		$tipo = "individual";
	}
	if ( $habilidad['tipo'] == Habilidades::TIPO_GRUPAL ) {
		$tipo = "grupal";
	}
	echo "<h3>Acci&oacute;n ".$tipo.": ".$habilidad['nombre']."</h3>";
	echo "Se ha ejecutado correctamente.";
?>