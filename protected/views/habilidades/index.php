<?php
// @var $acciones
// @var $recursosUsuario
// @var $accionesDesbloqueadas
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/acordeon.js'); ?>

<h1>Mis habilidades</h1>

<div class="accordion">
    <h3 class="ui-accordion-header-active">Acciones individuales</h3>
    <div>
        <?php foreach ( $acciones as $accion ){ ?>
            <?php if ($accion['tipo'] == Habilidades::TIPO_INDIVIDUAL){ ?>
                <div class="habilidad">
                <ul>
                    <!-- Muestro el nombre de la accion -->
                    <li>
                        <?php echo $accion['nombre'];?>
                    </li>

                    <!-- Muestro los recursos de la accion -->
                    <li>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
                        <?php echo $accion['dinero']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
                        <?php echo $accion['animo']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
                        <?php echo $accion['influencias']; ?>
                    </li>

                    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
                    <li>
                        <?php if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){
                            if (($accion['tipo']==Habilidades::TIPO_GRUPAL) || ($accion['tipo']==Habilidades::TIPO_INDIVIDUAL)){
                                echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black"));      
                            } else { ?>
                                <?php echo "<b>No tienes suficientes recursos para usar la habilidad</b>"; ?>
                            <?php }
                        } ?>
                        <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                    </li>
                </ul>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <h3 class="ui-accordion-header-active">Acciones grupales</h3>
    <div>
        <?php foreach ( $acciones as $accion ){ ?>
            <?php if ($accion['tipo'] == Habilidades::TIPO_GRUPAL){ ?>
                <div class="habilidad">
                <?php if ( $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero']){ 
                    echo 'class="remarcado"'; 
                } ?>
                <ul>
                    <!-- Muestro el nombre de la accion -->
                    <li>
                        <?php echo $accion['nombre'];?>
                    </li>

                    <!-- Muestro los recursos de la accion -->
                    <li>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
                        <?php echo $accion['dinero']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
                        <?php echo $accion['animo']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
                        <?php echo $accion['influencias']; ?>
                    </li>

                    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
                    <li>
                        <?php if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){
                            if (($accion['tipo']==Habilidades::TIPO_GRUPAL) || ($accion['tipo']==Habilidades::TIPO_INDIVIDUAL)){
                                echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black"));      
                            } else { ?>
                                <?php echo "<b>No tienes suficientes recursos para usar la habilidad</b>"; ?>
                            <?php }
                        } ?>
                        <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                    </li>
                </ul>
                </div>
            <?php }
        } ?>
    </div>

    <h3 class="ui-accordion-header-active">Acciones pasivas</h3>
    <div>
        <?php foreach ( $acciones as $accion ){ ?>
            <?php if ($accion['tipo'] == Habilidades::TIPO_PASIVA){ ?>
                <div class="habilidad">
                <?php if ( $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero']){ 
                    echo 'class="remarcado"'; 
                } ?>
                <ul>
                    <!-- Muestro el nombre de la accion -->
                    <li>
                        <?php echo $accion['nombre'];?>
                    </li>

                    <!-- Muestro los recursos de la accion -->
                    <li>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
                        <?php echo $accion['dinero']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
                        <?php echo $accion['animo']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
                        <?php echo $accion['influencias']; ?>
                    </li>

                    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
                    <li>
                        <?php if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){
                            if (($accion['tipo']==Habilidades::TIPO_GRUPAL) || ($accion['tipo']==Habilidades::TIPO_INDIVIDUAL)){
                                echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black"));      
                            } else { ?>
                                <?php echo "<b>No tienes suficientes recursos para usar la habilidad</b>"; ?>
                            <?php }
                        } ?>
                        <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                    </li>
                </ul>
                </div>
            <?php }
        } ?>
    </div>

    <h3 class="ui-accordion-header-active ">Acciones de partido</h3>
    <div>
        <?php foreach ( $acciones as $accion ){ ?>
            <?php if ($accion['tipo'] == Habilidades::TIPO_PARTIDO){ ?>
                <div class="habilidad">
                <?php if ( $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero'] && $recursosUsuario['dinero'] < $accion['dinero']){ 
                    echo 'class="remarcado"'; 
                } ?>
                <ul>
                    <!-- Muestro el nombre de la accion -->
                    <li>
                        <?php echo $accion['nombre'];?>
                    </li>

                    <!-- Muestro los recursos de la accion -->
                    <li>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
                        <?php echo $accion['dinero']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
                        <?php echo $accion['animo']; ?>
                        <img class="iconos-recursos" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
                        <?php echo $accion['influencias']; ?>
                    </li>

                    <!-- Enlace para poder ver la habilidad con mas detalle en /habilidades/ver/{id_habilidad} -->
                    <li>
                        <?php if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){
                            if (($accion['tipo']==Habilidades::TIPO_GRUPAL) || ($accion['tipo']==Habilidades::TIPO_INDIVIDUAL)){
                                echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black"));      
                            } else { ?>
                                <?php echo "<b>No tienes suficientes recursos para usar la habilidad</b>"; ?>
                            <?php }
                        } ?>
                        <?php echo CHtml::button('Ver habilidad', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                    </li>
                </ul>
                </div>
            <?php }
        } ?>
    </div>
</div>