<?php
// @var $listaHabilidades

// codigo PHP
?>
<h1>Habilidades</h1>

<ul>
<?php foreach ( $accionesDesbloqueadas as $acciones ): ?>
    <li><?php echo $acciones["nombre"]; ?></li>
<?php endforeach; ?>
</ul>

<!-- codigo HTML -->