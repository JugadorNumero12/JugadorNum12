<?php
// @var $acciones
?>

<h1>Acciones del usuario</h1>

<ul>
<?php foreach ( $acciones as $accion ){ ?>
	<li>
	<a href="<?php echo $this->createUrl('acciones/ver', array('id_habilidad' => $accion[0]['id_habilidad']));?>">
    <?php echo $accion[0]['nombre']; ?> </a>
    <?php printf('(D:%d, A:%d, I:%d)', $accion[0]['dinero'], $accion[0]['animo'], $accion[0]['influencias']); ?>
    </li>
<?php } ?>
</ul>