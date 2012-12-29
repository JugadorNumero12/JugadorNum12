<?php
// @var $acciones
// @var $recursosUsuario
?>

<h1>Acciones del usuario</h1>

<?php 
foreach ( $acciones as $accion ){ ?>
	<li>
	<!-- Comprobamos si el usuario puede realizar la acción o no puede por falta de recursos -->
	<?php if ($recursosUsuario[0]['dinero'] > $accion[0]['dinero'] &&
				$recursosUsuario[0]['animo'] > $accion[0]['animo'] &&
				$recursosUsuario[0]['influencias'] > $accion[0]['influencias']
				 ) { ?>
		<!-- Si tiene recursos suficientes se enlaza para poder usar la acción -->
		<a href="<?php echo $this->createUrl('acciones/usar', array('id_accion' => $accion[0]['id_habilidad']));?>">
    	<?php echo $accion[0]['nombre'];?>
    	</a>
    <?php } else {
    	//Si no puede por falta de recursos, se muestra la acción sin enlace
    	echo $accion[0]['nombre'];
    }
    printf('(D:%d, A:%d, I:%d)', $accion[0]['dinero'], $accion[0]['animo'], $accion[0]['influencias']); ?>
    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
    <a href="<?php echo $this->createUrl('habilidades/ver', array('id_habilidad' => $accion[0]['id_habilidad']));?>">
    <?php echo "Ver habilidad"?> </a>
    </li>
<?php } ?>