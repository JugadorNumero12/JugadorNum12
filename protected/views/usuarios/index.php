<!-- 
    variables disponibles
    ====================
    $this SiteController 
    $equipo (equipo del usuario con las acciones grupales abiertas)
    $proximoPartido (proximo partido del usuario)
    $primerTurno (necesario para determinar si el proximo partido esta jugandose)
    $ultimoTurno (necesario para determinar si el proximo partido esta jugandose)
-->

<?php
  Helper::registerStyleFile('inicio');
/*
  Yii::app()->clientScript->registerLinkTag(
    'stylesheet/less', 'text/css', 
    Yii::app()->request->baseUrl . '/less/inicio.less'
  );
*/
  ?>
  <!-- Escudo del equipo -->
  <div class = "escudo-equipo">
          <h2 class="dashboard-header"> Panel de control </h2>      
          <img src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$equipo->token.'.png'; ?>"
           width=185 height=185 alt="<?php echo $equipo->nombre ?>" >
  </div>

  <!-- Panel de control -->
  <div class = "inner-block dashboard-block">
      
      <!-- Atajo al perfil del hincha -->
      <h4> Mi personaje </h4>
      <p>
       Consulta el perfil de tu hincha &nbsp;
       <a href="<?php echo Yii::app()->createUrl('/usuarios/perfil') ?>" class="button">Perfil</a>
      </p>

      <!-- Atajo al prox partido -->
      <h4> Mi pr&oacute;ximo partido </h4>
        <p>
        <?php if($proximoPartido !== null) { ?>

          <a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$proximoPartido->local->id_equipo) )?>">
            <?php echo $proximoPartido->local->nombre ?> 
          </a> 
          <?php echo " vs "; ?>
          <a href="<?php //echo $this->createUrl('/equipos/ver', array('id_equipo'=>$proximoPartido->visitante->id_equipo) )?>">
            <?php echo $proximoPartido->visitante->nombre ?>
          </a>

          <?php echo Yii::app()->format->formatDatetime($proximoPartido->hora)?>
        
          &nbsp;

          <?php if ($proximoPartido->turno >= $primerTurno+1 && $proximoPartido->turno <= $ultimoTurno) { ?>
                <a href="<?php echo Yii::app()->createUrl( '/partidos/asistir?id_partido=' .$proximoPartido->id_partido ) ?>" class="button">Asistir</a>
          <?php } else {?>
                <a href="<?php echo Yii::app()->createUrl( '/partidos/previa?id_partido=' .$proximoPartido->id_partido ) ?>" class="button">Previa</a>
          <?php } ?> 

        <?php } else echo "No hay proximo partido" ?> <!-- end if proximoPartido !== null-->
        </p>

      <!-- Atajo a su aficion -->
      <h4> Mi afici&oacute;n </h4>
      <p> 
        Ayuda a tu equipo a ganar &nbsp;
        <?php echo CHtml::submitButton('Iniciar acción', array('submit' => array('/habilidades/index',),'class'=>"button small black")) ?> 
      </p>
  </div>
 
  <!-- Lista de acciones grupales -->
  <div class = "inner-block actions-block">

        <h4> Acciones grupales activas </h4>

        <table id="tabla-acciones"> 
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
                    <td> <?php echo CHtml::submitButton('Participar',array('submit' => array('/acciones/participar','id_accion'=>$ag->id_accion_grupal),'class'=>"button small black"));?> 	</td>		
                </tr>
            <?php } ?>
        </table>
  </div>

