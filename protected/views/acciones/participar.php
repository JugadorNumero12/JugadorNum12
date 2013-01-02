<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<h1>Participar en la acción grupal: <?php echo $habilidad['nombre']; ?></h1>
<h2> Aportar recursos </h2>

<form action="<?php $this->createUrl('acciones/participar'); ?>" method="post">
	<label> 
		<b> Dinero: </b>
		<input type="text" name="dinero" value=0 />
	</label>

	<label>
		<b> Animo: </b>
		<input type="text" name="animo" value=0 />
	</label>

	<label>
		<b> Influencia: </b>
		<input type="text" name="influencias" value=0 />
	</label>

	<input type="submit" value="Participar"/>
</form>