<?php
// @var $datosVista

?>
<div id="info-habilidad">
	<div id="info-cabecera">
		<div id="logo-habilidad">	
			<img alt="imagen habilidad" src="<?php echo Yii::app()->BaseUrl ?>/images/habilidades/<?php echo $habilidad['token'] ?>.png"  width="100px" height="100px"/>			
		</div>
		<div id="nombre-habilidad">
			<?php echo $habilidad['nombre']; ?>
		</div>
		<div id="logo-habilidad">
			<img alt="imagen habilidad" src="<?php echo Yii::app()->BaseUrl ?>/images/habilidades/<?php echo $habilidad['token'] ?>.png"  width="100px" height="100px"/>
		</div>
	</div>
	<div id="info-desbloqueada">
		<?php
			if ($desbloqueada)
			{ 
				echo "<span id=\"span-desb\">Ya has adquirido esta habilidad</span>";
			} 
			else 
			{
				echo CHtml::button('Adquirir habilidad', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black"));
			}
		?>
	</div>
	<div id="info-avanzada">
		<hr>
			<p><b>Tipo habilidad: </b></p>
			<p>
			 <?php
										switch ($habilidad['tipo']){
											case Habilidades::TIPO_INDIVIDUAL:
												echo 'Acci&oacute;n individual.';
											  break;
											case Habilidades::TIPO_GRUPAL:
											  	echo 'Acci&oacute;n grupal.';
											  break;
											case Habilidades::TIPO_PARTIDO:
											  	echo 'Acci&oacute;n de partido.';
											  break;
											case Habilidades::TIPO_PASIVA:
											  	echo 'Acci&oacute;n pasiva.';
											  break;
										}
										?>
			</p>
		<hr>
		<p><b>Descripci&oacute;n:</b></p><p> <?php echo $habilidad['descripcion']; ?></p>

		<?php if($habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL
					|| $habilidad['tipo'] == Habilidades::TIPO_GRUPAL
					|| $habilidad['tipo'] == Habilidades::TIPO_PARTIDO)
					{ ?>
						<hr>
						<p> 
						<?php
							echo '<b>Recursos necesarios para activar la habilidad: </b></p><p>';
							echo '<b><img class="info-gasto" src="'.Yii::app()->BaseUrl."/images/menu/recurso_dinero.png".'" alt="Icono dinero"> </b><span class="info-gasto-txt">'.$habilidad['dinero'].'</span>'.
							'<b><img class="info-gasto" src="'.Yii::app()->BaseUrl."/images/menu/recurso_animo.png".'" alt="Icono animo"></b><span class="info-gasto-txt">'.$habilidad['animo'].'</span>'.
							'<b><img class="info-gasto" src="'.Yii::app()->BaseUrl."/images/menu/recurso_influencia.png".'" alt="Icono influencia"> </b><span class="info-gasto-txt">'.$habilidad['influencias'].'</span>';
						?>
						</p>
				<?php } ?>

 		<hr>
		<p><b>Condiciones necesarias para desbloquear la habilidad:</b></p>
		<p> Nivel: <?php echo $nivel; ?> </p>
		<p>
			Habilidades previamente desbloqueadas necesarias:
			<?php
				if (count($requisitos) == 0){
					echo "Ninguna";
				} else { 
					foreach ($requisitos as $h){ ?>
						<p> <?php echo "- ".$h; ?></p>
					<?php }
				} ?>	
		</p>

		<?php
				if($habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL)
				{ ?>
					<hr>
					<p> <?php
					$time = (int)$habilidad['cooldown_fin'];
					printf( '<b>Cooldown: </b></p><p>%02d h &nbsp; %02d m &nbsp; %02d s', $time / 3600, $time / 60 % 60, $time % 60 );
					?>
					</p>
					<?php
				}
				if($habilidad['tipo'] == Habilidades::TIPO_GRUPAL)
				{?>
					<hr>
					<p> <?php
					$time = $habilidad['cooldown_fin'];
					printf( '<b>Finalizaci&oacute;n: </b></p><p>%02d h &nbsp; %02d m &nbsp; %02d s', $time / 3600, $time / 60 % 60, $time % 60 );
					?>
					</p>
					<?php					
				}
			?>
	</div>
</div>