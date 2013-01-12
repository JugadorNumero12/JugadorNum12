<?php
/* @var $modeloU */

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
								case Usuarios::PERSONAJE_ULTRA:
								  echo "Ultra" ;
								  break;
								case Usuarios::PERSONAJE_MOVEDORA:
								  echo "Relaciones públicas";
								  break;
								case Usuarios::PERSONAJE_EMPRESARIO:
								  echo "Empresario";
								  break;
								} ?></td>
		<td align="center"><?php echo $modeloU->nivel ?></td>
		<td align="center"><?php echo $modeloU->equipos->nombre ?></td>
	</tr>
	<tr></tr>
</table>