<!-- 
    variables disponibles
    ====================
    $this SiteController 
    $equipo (equipo del usuario con las acciones grupales abiertas)
    $proximoPartido (proximo partido del usuario)
    $primerTurno (necesario para determinar si el proximo partido esta jugandose)
    $ultimoTurno (necesario para determinar si el proximo partido esta jugandose)
-->

<div class = "envoltorio-perfil"> <div class="envoltorio2-perfil">
    <div class = "perfil-izquierda">
        <h3 class="titulo-subrayado"> Tu equipo </h3>

        <div class = "perfil-izquierda-equipo">
            <img src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$equipo->token.'.png'; ?>"
             width=150 height=150 alt="<?php echo $equipo->nombre ?>" >
        </div>

        <div class = "perfil-izquierda-partido">
          
          <h4> Pr&oacute;ximo partido </h4>
            <div class = "info-proximo-partido">

              <?php if($proximoPartido !== null) { ?>

                <a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$proximoPartido->local->id_equipo) )?>">
                  <?php echo $proximoPartido->local->nombre ?> 
                </a> 

                <a href="<?php //echo $this->createUrl('/equipos/ver', array('id_equipo'=>$proximoPartido->visitante->id_equipo) )?>">
                  <?php echo $proximoPartido->visitante->nombre ?>
                </a>
      
                <?php echo Yii::app()->format->formatDatetime($proximoPartido->hora)?>
              </div>

              <?php if($proximoPartido->turno >= $primerTurno+1 && $proximoPartido->turno < $ultimoTurno) { ?>
                <?php echo CHtml::submitButton('Asistir', array('submit' => array('/partidos/asistir','id_partido'=>$proximoPartido->id_partido),'class'=>"button small black")) ?> 
              <?php } else {?>
                <?php echo CHtml::submitButton('Previa', array('submit' => array('/partidos/previa','id_partido'=> $proximoPartido->id_partido),'class'=>"button small black")) ?>
              <?php } ?> 

            <?php } else echo "No hay proximo partido" ?> <!-- end if proximoPartido !== null-->
        
        </div>
    </div>

    <div class = "perfil-derecha">
      <h3 class = "titulo-subrayado"> Tu afici&oacute;n </h3>

      <div class = "perfil-derecha-iniciar">
        <h4> Iniciar nueva acci&oacute;n </h4>
        <?php echo CHtml::submitButton('Iniciar acción', array('submit' => array('/acciones/index',),'class'=>"button small black")) ?> 
      </div>

      <div class = "perfil-derecha-acciones">

            <h4> Acciones grupales activas </h4>
            <table> 
                <tr> 
                    <th>Nombre</th>
                    <th>Creador</th>
                    <th>Participantes</th>
                    <th>Completada</th>
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
                        <td> <?php echo CHtml::submitButton('Ver',array('submit' => array('/acciones/ver','id_accion'=>$ag->id_accion_grupal),'class'=>"button small black"));?> 	</td>		
                    </tr>
                <?php } ?>
            </table>
    	
      </div>
    </div>

</div> </div>