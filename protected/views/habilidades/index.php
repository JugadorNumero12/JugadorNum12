<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $habilidades Array con todas las habilidades, obtenidas de la BDD */
?>

<h1>Habilidades</h1>

<ul>
<?php foreach ( $habilidades as $habilidad ): ?>
    <li><a href="<?php
    	echo $this->createUrl(
    		'/habilidades/ver',
    		array('id_habilidad' => $habilidad['id_habilidad'])
    	);
    ?>"><?php echo $habilidad['nombre']; ?> </a> <?php
    	printf('(D:%d, A:%d, I:%d)',
    		$habilidad['dinero'],
    		$habilidad['animo'],
    		$habilidad['influencias']
    	);
    ?></li>
<?php endforeach; ?>
</ul>