<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
/* @var $desbloqueadas Array que indica true si el usuario ha desbloqueado la habilidad y false si no la ha desbloqueada
/* @var $habilidadesRequisito Array que guarda las habilidades requisito para desbloquear la accion
/* @var $nivelRequerido Array que guarda el nivel requerido para desbloquear una habilidad */
?>

<div class="envoltorio">
<div class="encabezado"> <h1>&Aacute;rbol de habilidades</h1> </div>

<?php 
foreach ( $habilidades as $i=>$habilidad ){ ?>
    <div class="datos-accion">
    <div <?php if (!$desbloqueadas[$i]){ echo 'class="remarcado"'; } ?>>
    <li>
    <!-- Muestro el nombre de la accion -->
    <div class="nombre-accion">
        <?php echo $habilidad['nombre'];?>
    </div>
    <!-- Muestro el tipo de accion -->
    <div class="tipo-accion">
        <?php
            switch($habilidad['tipo']){
                case Habilidades::TIPO_GRUPAL:
                    echo "Accion grupal";
                    break;
                case Habilidades::TIPO_INDIVIDUAL:
                    echo "Accion individual";
                    break;
                case Habilidades::TIPO_PARTIDO:
                    echo "Accion de partido";
                    break;
                case Habilidades::TIPO_PASIVA:
                    echo "Accion pasiva";
                    break;
            }; 
        ?>
    </div>
    <!--Añado la descripcion de la habilidad -->
    <div class="descripcion-accion"> <?php echo $habilidad['descripcion'];?> </div>    
    <!-- Muestro los recursos de la accion -->
    <div class="recursos-accion">
    <?php 
    if ($habilidad['tipo'] != Habilidades::TIPO_PASIVA)
        printf('<b>Dinero:</b>%d <b>Animo</b>:%d <b>Influencias:</b>%d', $habilidad['dinero'], $habilidad['animo'], $habilidad['influencias']);
    ?>
    </div>

    <!-- Muestro los requisitos de la accion  -->
    Requisitos para desbloquear la accion <br>
    Nivel: <?php echo $nivel[$i];  ?>  <br>
    Hab previas desbloqueadas necesarias 
    <?php 
    if (count($requisitos[$i]['desbloqueadas_previas']) == 0){ echo "Ninguna"; }
    foreach ($requisitos[$i]['desbloqueadas_previas'] as $h) {
            echo $h." ";
        }?> <br>

    <div class="botones-accion">
    <?php if (!$desbloqueadas[$i] && $puedeDesbloquear[$i]){
        echo CHtml::button('Adquirir habilidad', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black"));
    } else { 
            if($desbloqueadas[$i]) {?>
                <div class="mensaje"> <?php echo "<b>Ya has adquirido esta habilidad</b>"; ?> </div>

            <?php } else{
                if (!$puedeDesbloquear[$i]){?>
                    <div class="mensaje"> <?php echo "<b>No puedes desbloquear esta habilidad</b>"; ?> </div>
               <?php  }


            }?> 
    <?php } ?>
    <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black")); ?>
    </div>
    </li>
    </div>
    </div>
<?php } ?>
</div>
