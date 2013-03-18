$.fn.setIdEquipo = function(val) {
    $('#ocup')[0].value = val; 
	$(".escudo-seleccion").removeClass("escudo-seleccion");
    $(this).addClass("escudo-seleccion");
};