<?php
// @var $acciones
// @var $recursosUsuario
?>

<h1>Acciones desbloqueadas por el usuario</h1>

<?php 
foreach ( $acciones as $accion ){ ?>
	<li>
	<!-- Comprobamos si el usuario puede realizar la acción o no puede por falta de recursos -->
	<?php if ($recursosUsuario['dinero'] > $accion['dinero'] &&
				$recursosUsuario['animo'] > $accion['animo'] &&
				$recursosUsuario['influencias'] > $accion['influencias']
				 ) { ?>
		<!-- Si tiene recursos suficientes se enlaza para poder usar la acción -->
		<a href="<?php echo $this->createUrl('acciones/usar', array('id_accion' => $accion['id_habilidad']));?>">
    	<?php echo $accion['nombre'];?>
    	</a>
    <?php } else {
    	//Si no puede por falta de recursos, se muestra la acción sin enlace
    	echo $accion['nombre'];
    }
    printf('(D:%d, A:%d, I:%d)', $accion['dinero'], $accion['animo'], $accion['influencias']); ?>
    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
    <a href="<?php echo $this->createUrl('habilidades/ver', array('id_habilidad' => $accion['id_habilidad']));?>">
    <input type="button" value="Ver habilidad"/> </a>
    </li>
<?php } ?>