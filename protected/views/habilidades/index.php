<?php
// @var $acciones
// @var $recursosUsuario
// @var $accionesDesbloqueadas
// @var $usuario
?>

<?php
    Yii::app()->clientScript->registerLinkTag(
        'stylesheet/less', 'text/css', 
        Yii::app()->request->baseUrl . '/less/habilidades.less'
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/acordeon.js');
?>

<h1 class="titulo-habilidades">Habilidades</h1>

<div class="accordion">
    <?php for ($i = 1; $i <= 4; $i++){ ?>
    <h3 class="ui-accordion-header-active"><b>Nivel <?php echo $i; ?></b></h3>
    <div>
        <div class="habilidades">
        <?php foreach ( $acciones as $accion ){ ?>
            <?php if (RequisitosDesbloquearHabilidades::$datos_acciones[$accion->codigo]['nivel'] == $i){ ?>
                <div class="habilidad <?php if(!$usuario->estaDesbloqueada($accion['id_habilidad'])){ echo 'remarcado-sin-desbloquear';}?>
                                         <?php if(($recursosUsuario['dinero'] < $accion['dinero'] || $recursosUsuario['animo'] < $accion['animo'] || $recursosUsuario['influencias'] < $accion['influencias']) 
                                            && ($accion['tipo'] == Habilidades::TIPO_INDIVIDUAL || $accion['tipo'] == Habilidades::TIPO_GRUPAL) ){ echo 'remarcado-usar';} ?>">
                    <!-- Muestro el nombre de la accion -->
                    <div class="icono-habilidad">
                        <img src="<?php echo Yii::app()->BaseUrl.'/images/habilidades/' . $accion['token'] . '.png';?>">
                    </div>

                    <div class="nombre-habilidad">
                        <b><?php echo $accion['nombre'];?></b>
                    </div>

                    <div>
                        <div class="tipo-habilidad">
                            <?php switch($accion['tipo']){
                                case Habilidades::TIPO_INDIVIDUAL: ?>
                                    <div>
                                        <img src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_individual.png';?>" alt="Habilidad individual" width="36" height="36">
                                    </div>
                                    <div class="texto-datos-habilidad">
                                        <b><?php echo 'Individual'; ?></b>
                                    </div>
                                    <?php break;
                                case Habilidades::TIPO_GRUPAL: ?>
                                    <div>
                                        <img src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_grupal.png';?>" alt="Habilidad grupal" width="36" height="36">
                                    </div>
                                    <div class="texto-datos-habilidad">
                                        <b><?php echo 'Grupal'; ?></b>
                                    </div>
                                    <?php break;
                                case Habilidades::TIPO_PASIVA: ?>
                                    <div>
                                        <img src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_pasiva.png';?>" alt="Habilidad pasiva" width="36" height="36">
                                    </div>
                                    <div class="texto-datos-habilidad">
                                        <b><?php echo 'Pasiva'; ?></b>
                                    </div>
                                    <?php break;
                                case Habilidades::TIPO_PARTIDO: ?>
                                    <div>
                                        <img src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_partido.png';?>" alt="Habilidad de partido" width="36" height="36">
                                    </div>
                                    <div class="texto-datos-habilidad">
                                        <b><?php echo 'Partido'; ?></b>
                                    </div>
                                    <?php break;
                            } ?>
                        </div>

                        <div class="recursos-habilidad">
                            <div>
                                <img src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_dinero.png';?>" alt="Icono dinero" width="36" height="36">
                            </div>
                            <div <?php if(($recursosUsuario['dinero'] < $accion['dinero']) && ($accion['tipo'] == Habilidades::TIPO_INDIVIDUAL || $accion['tipo'] == Habilidades::TIPO_GRUPAL || ($accion['tipo'] == Habilidades::TIPO_PASIVA && !($usuario->estaDesbloqueada($accion['id_habilidad']))) || ($accion['tipo'] == Habilidades::TIPO_PARTIDO && !($usuario->estaDesbloqueada($accion['id_habilidad']))))) { echo 'class="remarcado-recurso"';};?>>
                                <b><?php echo $accion['dinero']; ?></b>
                            </div>
                        </div>

                        <div class="recursos-habilidad">
                            <div>
                                <img src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_animo.png';?>" alt="Icono animo" width="36" height="36">
                            </div>
                            <div <?php if(($recursosUsuario['animo'] < $accion['animo']) && ($accion['tipo'] == Habilidades::TIPO_INDIVIDUAL || $accion['tipo'] == Habilidades::TIPO_GRUPAL || ($accion['tipo'] == Habilidades::TIPO_PASIVA && !($usuario->estaDesbloqueada($accion['id_habilidad']))) || ($accion['tipo'] == Habilidades::TIPO_PARTIDO && !($usuario->estaDesbloqueada($accion['id_habilidad']))))) { echo 'class="remarcado-recurso"';};?>>
                                <b><?php echo $accion['animo']; ?></b>
                            </div>
                        </div>

                        <div class="recursos-habilidad">
                            <div>
                                <img src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_influencia.png';?>" alt="Icono influencias" width="36" height="36">
                            </div>
                            <div <?php if(($recursosUsuario['influencias'] < $accion['influencias']) && ($accion['tipo'] == Habilidades::TIPO_INDIVIDUAL || $accion['tipo'] == Habilidades::TIPO_GRUPAL || ($accion['tipo'] == Habilidades::TIPO_PASIVA && !($usuario->estaDesbloqueada($accion['id_habilidad']))) || ($accion['tipo'] == Habilidades::TIPO_PARTIDO && !($usuario->estaDesbloqueada($accion['id_habilidad']))))) { echo 'class="remarcado-recurso"';};?>>
                               <b><?php echo $accion['influencias']; ?></b>
                            </div>
                        </div>
                    </div>

                    <!-- Botones para poder usar o adquirir y para poder ver la habilidad con mas detalle -->
                    <div class="botones-habilidad">
                        <?php if (($accion['tipo']==Habilidades::TIPO_INDIVIDUAL) || ($accion['tipo']==Habilidades::TIPO_GRUPAL)){
                            if ($usuario->estaDesbloqueada($accion['id_habilidad'])){
                                // La habilidad está desbloqueada
                                if ( $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){ ?>
                                    <!-- El usuario tiene suficientes recursos para poder usar la habilidad -->
                                    <div>
                                        <?php echo CHtml::button('Usar', array('submit' => array('acciones/usar', 'id_accion'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                                    </div>   
                                <?php }   
                            } else {
                                //La habilidad no está desbloqueada
                                if ($accion->puedeDesbloquear(Yii::app()->user->usIdent, $accion['id_habilidad']) && $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){ ?>
                                    <!-- La habilidad puede desbloquearse -->
                                    <div>
                                        <?php echo CHtml::button('Desbloquear', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                                    </div>     
                                <?php }
                            }
                        } ?>
                        <?php if (($accion['tipo']==Habilidades::TIPO_PASIVA) || ($accion['tipo']==Habilidades::TIPO_PARTIDO)){
                            if (!($usuario->estaDesbloqueada($accion['id_habilidad']))){
                                if ($accion->puedeDesbloquear(Yii::app()->user->usIdent,$accion['id_habilidad']) && $recursosUsuario['dinero'] >= $accion['dinero'] && $recursosUsuario['animo'] >= $accion['animo'] && $recursosUsuario['influencias'] >= $accion['influencias']){ ?>
                                    <!-- La habilidad puede adquirirse -->
                                    <div>
                                        <?php echo CHtml::button('Desbloquear', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                                    </div>
                                <?php }  
                            }
                        } ?>
                        <!-- Botón para poder ver la habilidad con mas detalle -->
                        <div>
                            <?php echo CHtml::button('Detalles', array('submit' => array('habilidades/ver', 'id_habilidad'=>$accion['id_habilidad']),'class'=>"button small black")); ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
    </div>
    <?php } ?>