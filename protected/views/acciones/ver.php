<?php
/* @var $accionGrupal */
/* @var habilidades */

// codigo PHP
?>
<<<<<<< HEAD

<h1>Accion Grupal: <?php echo $habilidades[0]['nombre']; ?></h1>
=======
>>>>>>> develop

<ul>
<?php foreach ( $accionGrupal as $accion ){ ?>
	<?php foreach ( $habilidades as $habilidad ){ ?>
		<li>
    	<?php echo $habilidad['codigo']; ?>
    	</li>
	<?php } ?>    
<?php } ?>
</ul>
