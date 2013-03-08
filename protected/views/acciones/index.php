<?php
// @var $acciones
// @var $recursosUsuario
?>

<div class="envoltorio">
<div class="encabezado"> <h1>Habilidades desbloqueadas</h1> </div>

<?php 
foreach ( $acciones as $accion ){ ?>
    <div class="datos-accion">
    <div <?php if ( $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero']){ echo 'class="remarcado"'; } ?>>
	<li>
    <!-- Muestro el nombre de la accion -->
    <div class="nombre-accion">
        <?php echo $accion['nombre'];?>
    </div>
    <!-- Muestro el tipo de accion -->
    <div class="tipo-accion">
        <?php
            switch($accion['tipo']){
                case Habilidades::TIPO_GRUPAL:
                    echo "Acción grupal";
                    break;
                case Habilidades::TIPO_INDIVIDUAL:
                    echo "Acción individual";
                    break;
                case Habilidades::TIPO_PARTIDO:
                    echo "Acción de partido";
                    break;
                case Habilidades::TIPO_PASIVA:
                    echo "Acción pasiva";
                    break;
            }; 
        ?>
    </div>
    <!--Añado la descripcion de la habilidad -->
    <div class="descripcion-accion"> <?php echo $accion['descripcion'];?> </div>    
    <!-- Muestro los recursos de la accion -->
    <div class="recursos-accion">
    <?php 
    printf('<b>Dinero:</b>%d <b>&Aacute;nimo</b>:%d <b>Influencias:</b>%d', $accion['dinero'], $accion['animo'], $accion['influencias']);
    ?>
    </div>
    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
    <div class="botones-accion">
    <?php if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['dinero'] >= $accion['dinero']){
        if (($accion['tipo']==Habilidades::TIPO_GRUPAL) || ($accion['tipo']==Habilidades::TIPO_INDIVIDUAL))
        {
            echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black"));
        }        
    } else { ?>
        <div class="mensaje"> <?php echo "<b>No tienes suficientes recursos para usar la habilidad</b>"; ?> </div>
    <?php } ?>
    <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
    </div>
    </li>
    </div>
    </div>
<?php } ?>
</div>