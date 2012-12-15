<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
?>

<h1>Habilidades</h1>

<ul>
<?php foreach ( $habilidades as $habilidad ): ?>
  <li><a <?php
    echo 'href="'
       . Yii::app()->createUrl('/habilidades/ver', array('id_habilidad' => $habilidad['id_habilidad']))
       . '"'; ?>>
       Hab. #<?php echo $habilidad['id_habilidad']; ?> </a></li>
<?php endforeach; ?>
</ul>