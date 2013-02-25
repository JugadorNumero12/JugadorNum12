<?php
/* @var habilidad La habilidad (acción) que se está intentando usar y toda su info */
// @var $res -> Recursos del usuario
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
			<tr><th>Animo: </th><td><?php echo ($res['animo'] + $habilidad['animo']); ?></td></tr>
		</table>

		<div class="encabezado-pequeño-usar"> <h3>Recursos del usuario después de usar la acción</h3> </div>
		<table class="tablas-usar">
			<tr><th>Dinero: </th><td><?php echo $res['dinero']; ?></td></tr>
			<tr><th>Influencias: </th><td><?php echo $res['influencias']; ?></td></tr>
			<tr><th>Animo: </th><td><?php echo $res['animo']; ?></td></tr>
		</table>

		<div class="botones-usar">
			<?php
			if ( $habilidad['tipo'] == Habilidades::TIPO_GRUPAL ){ ?>
				<?php echo CHtml::button('Participar', array('submit' => array('acciones/participar', 'id_accion'=>$id_acc),'class'=>"button small black")); ?>
			<?php } ?>
			<?php echo CHtml::button('Volver', array('submit' => array('index'),'class'=>"button small black")); ?>
		</div>
</div>