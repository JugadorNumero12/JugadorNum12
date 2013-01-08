<?php
/* @var $msg El mensaje a mostrar al ususario*/
/* @var $url_ok la direccion si acepta */
/* @var $url_no la direccion si cancela */
// muestra un alert y pide confirmacion al usuario
?>
<script type="text/javascript">
if(confirm(<?php echo $msg;?>))
	window.location = <?php echo $url_ok;?>;
else
	window.location = <?php echo $url_no;?>;
</script>