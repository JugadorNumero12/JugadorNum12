<?php
/* 	@var $id_acc: id de acción grupal para poder participar
	@var $habilidad La habilidad (acción) que se está intentando usar y toda su info */
// 	@var $res -> Recursos del usuario
?>

<div class="envoltorio-acciones-usar">
	<div class="encabezado-usar"> <h1>Usar acci&oacute;n</h1> </div>
		<div class="mensaje-usar">
			<h2><?php echo "La acción '" .$habilidad['nombre']. "' se ha completado con éxito"; ?></h2>
		</div>

		<div class="encabezado-pequeño-usar"> <h3>Recursos del usuario antes de usar la acción</h3> </div>
		<table class="tablas-usar">
			<tr><th>Dinero: </th><td><?php echo ($res['dinero'] + $habilidad['dinero']); ?></td></tr>
			<tr><th>Influencias: </th><td><?php echo ($res['influencias'] + $habilidad['influencias']); ?></td></tr>
			<tr><th>&Aacute;nimo: </th><td><?php echo ($res['animo'] + $habilidad['animo']); ?></td></tr>
		</table>

		<div class="encabezado-pequeño-usar"> <h3>Recursos del usuario después de usar la acción</h3> </div>
		<table class="tablas-usar">
			<tr><th>Dinero: </th><td><?php echo $res['dinero']; ?></td></tr>
			<tr><th>Influencias: </th><td><?php echo $res['influencias']; ?></td></tr>
			<tr><th>&Aacute;nimo: </th><td><?php echo $res['animo']; ?></td></tr>
		</table>

		<div class="botones-usar">	
			<?php echo CHtml::button('Aceptar', array('submit' => array('acciones/ver', 'id_accion'=>$id_acc),'class'=>"button small black")); ?>
		</div>
</div>