<?php
// @var $listaHabilidades

// codigo PHP
?>
<h1>Habilidades</h1>

<ul>
<?php foreach ( $listaHabilidades as $habilidad ): ?>
    <li><?php echo $habilidad["habilidades_id_habilidad"]; ?></li>
<?php endforeach; ?>
</ul>

<!-- codigo HTML -->