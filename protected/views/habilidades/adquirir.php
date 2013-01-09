<?php
/* @var $habilidad pasamos la informacion de la habilidad que estamos desbloqueando */

// codigo PHP

?>
<h3>Adquirir habilidad</h3>
<p>&iquest;Desea desbloquear la habilidad <?php echo $habilidad['nombre']?>?</p>
<form action="<?php $this->createUrl('/habilidades/adquirir'); ?>" method="post">
	<input type="submit" name="aceptarBtn"  value="Aceptar"/>
	<? echo '&nbsp;&nbsp;&nbsp;'; ?>
	<input type="submit" name="cancelarBtn" value="Cancelar"/>
</form>