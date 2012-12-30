<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP 

?>

<!-- codigo HTML -->

<h1> PERFIL DE OTRO USUARIO</h1>

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