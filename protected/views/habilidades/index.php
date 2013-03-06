<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
// @var $desbloqueadas
?>

<div class="envoltorio">
<div class="encabezado"> <h1>&Aacute;rbol de habilidades</h1> </div>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

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

    <div class="botones-accion">
    <?php if (!$desbloqueadas[$i]){
        echo CHtml::button('Adquirir habilidad', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black"));
    } else { ?>
        <div class="mensaje"> <?php echo "<b>Ya has adquirido esta habilidad</b>"; ?> </div>
    <?php } ?>
    <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black")); ?>
    </div>
    </li>
    </div>
    </div>
<?php } ?>
</div>