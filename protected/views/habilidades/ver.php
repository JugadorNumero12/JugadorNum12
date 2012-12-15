<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<h1>Habilidad: <?php echo $habilidad['nombre']; ?></h1>

<a href="<?php echo $this->createUrl('/habilidades/index'); ?>">&larr; Habilidades</a>

<p><?php echo $habilidad['descripcion']; ?></p>
<p><?php echo ($habilidad['tipo']==Habilidades::TIPO_INDIVIDUAL) ? 'Individual' : 'Grupal' ?></p>
<p>Coste:<ul>
	<li>Dinero <?php echo $habilidad['dinero']; ?></li>
	<li>&Aacute;nimo <?php echo $habilidad['animo']; ?></li>
	<li>Influencia <?php echo $habilidad['influencias']; ?></li>
</ul></p>

<?php if ($habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL): ?>
<p></p>
<?php else: ?>
<p></p>
<?php endif; ?>

<a href="<?php echo $this->createUrl('/habilidades/index'); ?>">&larr; Habilidades</a>

<!-- codigo HTML -->