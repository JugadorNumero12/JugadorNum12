  $(function() {

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
	});

	  $('#link-habilidades').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-habilidades').show();
	});

	$('#link-partido').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-partido').show();
	});

	$('#link-participar').click(function(){
		$('.cuadro-ayuda').hide();
		$('#ayuda-participar').show();
	});

  });