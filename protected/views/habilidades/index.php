<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
/* @var $desbloqueadas Array que indica true si el usuario ha desbloqueado la habilidad y false si no la ha desbloqueada
/* @var $requisitos Array que guarda los requisitos par desbloquear una accion
/* @var $puedeDesbloquear Array que indica true si se puede desbloquear la accion y false si no se puede*/
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

    <!-- Muestro los requisitos de la accion  -->
    Requisitos para desbloquear la accion <br>
    Nivel: <?php echo $requisitos[$i]['nivel'];  ?>  <br>
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
    
<?php } ?>
</div>
