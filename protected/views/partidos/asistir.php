<?php
/* @var $equipoL modelo del equipo local */
/* @var $equipoV modelo del equipo visitante */
/* @var $cronica cronica del partido */
/* @var $sigPartido modelo del siguiente partido al que se puede asistir */
// codigo PHP

?>

<h3>Cr&oacute;nica del partido: <?php echo $equipoL['nombre'].' vs '.$equipoV['nombre']; ?></h3>
</br>
<?php echo $cronica; ?>