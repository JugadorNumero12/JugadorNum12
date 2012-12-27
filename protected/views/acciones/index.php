<?php
// @var $acciones
?>

<h1>Acciones</h1>

<ul>
<?php foreach ( $acciones as $accion ){ ?>
	<li>
    <?php echo $accion[0]['nombre']; ?>
    <?php printf('(D:%d, A:%d, I:%d)', $accion[0]['dinero'], $accion[0]['animo'], $accion[0]['influencias']); ?>
    </li>
<?php } ?>
</ul>