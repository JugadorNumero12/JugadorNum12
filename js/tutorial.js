  $(function() {

  	function desactivarMenuSeleccionado()
	{
		$('#link-personajes').removeClass("menu-seleccionado");
		$('#link-habilidades').removeClass("menu-seleccionado");
		$('#link-partido').removeClass("menu-seleccionado");
		$('#link-participar').removeClass("menu-seleccionado");
		$('#link-objetivo').removeClass("menu-seleccionado");
	}

  	$( "#ayuda-menu" ).hide();
    $( "#ayuda-menu" ).draggable();
    $( ".cuadro-ayuda" ).hide();
    $( ".cuadro-ayuda" ).draggable();

    $('#button-ayuda').click(function(){
		$('#ayuda-menu').show();
	});

	 $('#cerrar-ayuda').click(function(){
		$('#ayuda-menu').hide();
		$('.cuadro-ayuda').hide();
	});

	$('#link-personajes').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-personajes').show();
		desactivarMenuSeleccionado();
		$('#link-personajes').addClass("menu-seleccionado");
	});

	  $('#link-habilidades').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-habilidades').show();
		desactivarMenuSeleccionado();
		$('#link-habilidades').addClass("menu-seleccionado");
	});

	$('#link-partido').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-partido').show();
		desactivarMenuSeleccionado();
		$('#link-partido').addClass("menu-seleccionado");
	});

	$('#link-participar').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-participar').show();
		desactivarMenuSeleccionado();
		$('#link-participar').addClass("menu-seleccionado");
	});

	$('#link-objetivo').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-objetivo').show();
		desactivarMenuSeleccionado();
		$('#link-objetivo').addClass("menu-seleccionado");
	});

  });