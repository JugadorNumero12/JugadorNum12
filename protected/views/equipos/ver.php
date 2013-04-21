<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion

?>

<?php
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/aficion.less'
	);
?>
<!-- codigo HTML -->
<div id="contenedor-descripcion-equipo">
	<div id="escudo-equipo">
		<img
			src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$equipo->token.'.png'; ?>"
			width=150 height=150 
			alt="<?php echo $equipo->nombre ?>"/> 
	</div>

	<div id="descripcion-equipo">
		<?php if($mi_equipo){ ?>
			<h1> Tu equipo </h1>
		<?php } else {?>
			<h1> Equipo rival </h1>
		<?php } ?>
		<ul>
			<li>Nombre equipo: <?php echo $equipo->nombre ?> </li> 
			<li>Nivel del equipo: <?php echo $equipo->nivel_equipo ?></li>
			<li>Aforo m&aacute;ximo del estadio: <?php echo $equipo->aforo_max ?> </li>	
			<li>Aforo b&aacute;sico del estadio: <?php echo $equipo->aforo_base ?> </li> 					 
		</ul>
	</div>
</div>

<?php if(!$mi_equipo){ ?>
	<td><?php echo CHtml::button('Cambiar equipo', array('submit' => array('equipos/cambiar', 'id_nuevo_equipo'=>$equipo->id_equipo), 'class'=>"button small black")); ?></td>
<?php } ?>

<?php if($mi_equipo && count($equipo->usuarios) >1){ ?>
		<td><?php echo CHtml::button('Mandar mensaje a los compañeros', array('submit' => array('emails/mensajeEquipo', 'id_equipo'=>$equipo->id_equipo), 'class'=>"button small black")); ?></td>	
<?php } ?>

<div id="contenedor">
	    <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
	    <label for="tab-1" class="tab-label-1">Acciones Grupales</label>
	    
	    <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
	    <label for="tab-2" class="tab-label-2">Jugadores</label>                   
    <div class="content">
        <div class="content-1">
			<div id="tabla-acciones">

				<?php if($mi_equipo){ ?>

					<?php if(empty($equipo->accionesGrupales)){ ?>
						<h2> No hay acciones grupales </h2>
					<?php } else {?>
						<h2> Acciones grupales  </h2>
						<table > 
							<tr> 
								<th>Nombre</th>
								<th>Creador</th>
								<th>Participantes</th>
								<th>Completada</th>
								<th>&nbsp;</th>
							</tr>
						<?php foreach ($equipo->accionesGrupales as $ag){ ?> 
							<tr> 
								<td><?php echo  $ag->habilidades->nombre; ?> 	</td>
								<td><?php echo  $ag->usuarios->nick; ?> 	</td>
								<td><?php echo  $ag->jugadores_acc; ?> 	</td>	
								<td> <?php if($ag->completada) {?>
										S&iacute; 
									<?php } else {?>
										No 
									<?php }?>
									</td>
								<td> <?php  echo CHtml::link('Participar',array('acciones/participar','id_accion'=>$ag->id_accion_grupal),array('class'=>"button small black")); ?> 	</td>		
							</tr>				
						 <?php } ?>
						</table>
					<?php } ?>
				<?php } else {?>
					<h2> No puedes ver las del equipo rival </h2>
				<?php } ?>			
			</div>
        </div>
        <div class="content-2">
            <div id="tabla-jugadores">
				<?php if(empty($equipo->usuarios)){ ?>
					<h2>Este equipo no tiene jugadores</h2>
				<?php } else 
				{?>
					<h2> Jugadores </h2>
					<table > 
						<tr> 
							<th>Jugador</th>
							<th>Nivel</th>
							<th>Personaje</th>
						</tr>
						<?php foreach ($equipo->usuarios as $e){ ?>
							
							<tr> 
								<td><a href="<?php echo $this->createUrl( '/usuarios/ver', array('id_usuario' => $e->id_usuario) ); ?>">  
											<?php echo $e->nick ?></td>
									</a> 	
								<td><?php echo  $e->nivel; ?> 	</td>
								<td><?php switch($e->personaje){
										case Usuarios::PERSONAJE_ULTRA:
											echo "Ultra";
											break;
										case Usuarios::PERSONAJE_MOVEDORA:	
											echo "Animadora";
											break;
										case Usuarios::PERSONAJE_EMPRESARIO:
											echo "Empresario";
											break;	
									}; ?> 	</td>								
							</tr>	
						<?php } ?>
					</table>
				<?php }  ?>
			</div>
        </div>
    </div>
</div>

