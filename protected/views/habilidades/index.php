<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
?>

<div class="envoltorio">
<div class="encabezado"> <h1>Arbol de habilidades</h1> </div>

<?php 
foreach ( $habilidades as $habilidad ){ ?>
    <div class="datos-accion">
    <div <?php if (true){ echo 'class="remarcado"'; } ?>>
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
    printf('<b>Dinero:</b>%d <b>Animo</b>:%d <b>Influencias:</b>%d', $habilidad['dinero'], $habilidad['animo'], $habilidad['influencias']);
    ?>
    </div>

    <div class="botones-accion">
    <?php if (true){
        echo CHtml::button('Adquirir habilidad', array('submit' => array('acciones/adquirir', 'id_accion'=>$habilidad['id_habilidad'])));
    } else { ?>
        <div class="mensaje"> <?php echo "<b>Ya has adquirido esta habilidad</b>"; ?> </div>
    <?php } ?>
    <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$habilidad['id_habilidad']))); ?>
    </div>
    </li>
    </div>
    </div>
<?php } ?>
</div>