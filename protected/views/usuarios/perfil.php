<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP 

?>

<!-- codigo HTML -->

<h1> PERFIL DE USUARIO</h1>

<h3> DATOS BÁSICOS</h3>

<table cellspacing="5px">
	<tr>
		<th>Nick</th>
		<th>eMail</th>
		<th>Personaje</th>
		<th>Nivel</th>
		<th>Equipo</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloU->nick ?></td>
		<td align="center"><?php echo $modeloU->email ?></td>
		<td align="center"><?php switch ($modeloU->personaje)
								{
								case 0:
								  echo "Animadora" ;
								  break;
								case 1:
								  echo "Empresario";
								  break;
								case 2:
								  echo "Ultra";
								  break;
								} ?></td>
		<td align="center"><?php echo $modeloU->nivel ?></td>
		<td align="center"><?php echo $modeloE->nombre ?></td>
	</tr>
	<tr></tr>
</table>

<h3> RECURSOS </h3>

<table cellspacing="5px">
	<tr>
		<th>Dinero</th>
		<th>Influencia</th>
		<th>Ánimo</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloR->dinero ?></td>
		<td align="center"><?php echo $modeloR->influencias ?></td>
		<td align="center"><?php echo $modeloR->animo ?></td>
	</tr>
	<tr></tr>
</table>

<h3> GENERACIÓN DE RECURSOS </h3>

<table cellspacing="5px">
	<tr>
		<th align="center">Generación de dinero</th>
		<th align="center">Influencias máximas</th>
		<th align="center">Generación de influencias</th>
		<th align="center">Ánimo máximo</th>
		<th align="center">Generación de ánimo</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloR->dinero_gen ?></td>
		<td align="center"><?php echo $modeloR->influencias_max ?></td>
		<td align="center"><?php echo $modeloR->influencias_gen ?></td>
		<td align="center"><?php echo $modeloR->animo_max ?></td>
		<td align="center"><?php echo $modeloR->animo_gen ?></td>
	</tr>
</table>

<h3> HABILIDADES PASIVAS DESBLOQUEADAS </h3>

<?php foreach ( $accionesPas as $accion ){ ?>
	<li>
    <?php if ($accion != null) echo $accion[0]['nombre']; ?>
    </li>
<?php } ?>

	
