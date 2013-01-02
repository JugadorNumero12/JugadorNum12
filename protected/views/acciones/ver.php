<?php
/* @var $accionGrupal */
/* @var $habilidad */
// @var $usuario
// @var $propietarioAccion
// @var $participaciones

// codigo PHP
?>

<h1>Accion Grupal: <?php echo $habilidad['nombre']; ?></h1>

<p> <b>USUARIO QUE HA CREADO LA ACCION => </b>
		<?php $accionGrupal['usuarios_id_usuario']; ?>
</p>

<p> <b>NUMERO DE PARTICIPANTES => </b>
		<?php echo $accionGrupal['jugadores_acc']; ?>
</p>

<p> <b>TOTAL DE RECURSOS AÑADIDOS => </b>
		<?php printf('Dinero:%d', $accionGrupal['dinero_acc']); ?>
		&nbsp;
		<?php printf('Influencias:%d', $accionGrupal['influencias_acc']); ?>
		&nbsp;
		<?php printf('Animo:%d', $accionGrupal['animo_acc']); ?>
</p>

<p> <b>EFECTO QUE SE CONSIGUE => </b>
		<?php echo $habilidad['descripcion']; ?>
</p>

<p> <b>PARTICIPANTES Y RECURSOS AÑADIDOS POR CADA UNO </b> </p>

<p> <li>
	<?php 
		foreach ($participaciones as $participacion){
			printf('Usuario:%d', $participacion['usuarios_id_usuario']); ?>
			&nbsp;
			<?php printf('Dinero aportado: %d', $participacion['dinero_aportado']); ?>
			&nbsp;
			<?php printf('Influencias aportadas: %d', $participacion['influencias_aportadas']); ?>
			&nbsp;
			<?php printf('Animo aportado: %d', $participacion['animo_aportado']);
		} ?>
</p> </li>

<p> <b>FINALIZACION DE LA ACCION => </b>
	<?php echo $accionGrupal['finalizacion']; ?>
</p>

<p>
<?php 
if ($usuario == $propietarioAccion){ ?>
	<a href="<?php /*echo $this->createUrl(Aquí falta poner el enlace a la acción de expulsar jugadores);*/ ?>"> 
	<input type="button" value="Expulsar jugadores"/> </a>
<?php } ?>
</p>