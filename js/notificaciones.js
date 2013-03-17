(function($){
	$(document).ready(function(){
		
		$.jGrowl.defaults.closer = false;

		$.jGrowl.defaults.animateOpen = {
			width: 'show'
		};
		$.jGrowl.defaults.animateClose = {
			width: 'hide'
		};

		$.jGrowl.defaults.position = 'center';

		<?php if($aux == "algo" && $accionGrupal['completada'] == 1){ ?>
			$.jGrowl("¡Enhorabuena, has completado la acción¡", { sticky: true });
		<?php } ?>

		<?php if ($accionGrupal['completada'] == 1 && $aux != "algo"){ ?>
			$.jGrowl("La acción se ha completado", { sticky: true });
		<?php } ?>

		<?php if($aux == "nada" && $accionGrupal['completada'] != 1){ ?>
			$.jGrowl("No has aportado nada a la acción.", { sticky: true });
		<?php } ?>

		<?php if($aux == "algo" && $accionGrupal['completada'] != 1){ ?>
			$.jGrowl("Tu equipo agradece tu generosa contribución.", { sticky: true });
		<?php } ?>
	});
})(jQuery);