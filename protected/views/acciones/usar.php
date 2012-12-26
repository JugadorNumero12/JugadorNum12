<?php
/* @var habilidad La habilidad (acción) que se está intentando usar y toda su info */


?>

<form action="<?php $this->createUrl('/acciones/usar'); ?>" method="post">
	<label>
		Dinero inicial:
		<input type="text"
			name="dinero"
			value="<?php echo $habilidad['dinero'] ?>"/>
	</label>

	<label>
		&Aacute;nimo inicial:
		<input type="text"
			name="animo"
			value="<?php echo $habilidad['animo'] ?>"/>
	</label>

	<label>
		Influencia inicial:
		<input type="text"
			name="influencia" 
			value="<?php echo $habilidad['influencias'] ?>"/>
	</label>

	<input type="submit" value="Usar acci&oacute;n"/>
</form>