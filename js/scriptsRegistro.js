$.fn.setIdEquipo = function(val) {
    $('#ocup')[0].value = val; 
	$(".escudo-seleccion").removeClass("escudo-seleccion");
    $(this).addClass("escudo-seleccion");
};

$.fn.setIdPersonaje = function(val) {
    $('#'+val)[0].checked = true; 
	$(".pj-seleccion").removeClass("pj-seleccion");
    $(this).addClass("pj-seleccion");
};