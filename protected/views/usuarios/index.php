<!-- 
    variables disponibles
    ====================
    $this SiteController 
    $equipo
-->

<div class = "envoltorio-perfil"> <div class="envoltorio2-perfil">
    <div class = "perfil-izquierda">
        <div class = "perfil-izquierda-equipo">
            <img src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$equipo->token.'.png'; ?>"
             width=150 height=150 alt="<?php echo $equipo->nombre ?>" >
        </div>

        <div class = "perfil-izquierda-partido">

        </div>
    </div>

    <div class = "perfil-derecha">

    </div>

</div> </div>