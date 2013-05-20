  $(function() {

  	function desactivarMenuSeleccionado()
	{
		$('#link-personajes').removeClass("menu-seleccionado");
		$('#link-habilidades').removeClass("menu-seleccionado");
		$('#link-partido').removeClass("menu-seleccionado");
		$('#link-participar').removeClass("menu-seleccionado");
		$('#link-objetivo').removeClass("menu-seleccionado");
		$('#link-asistir-partido').removeClass("menu-seleccionado");
		$('#link-desarrollo-partido').removeClass("menu-seleccionado");
		$('#link-tutorial-0').removeClass("menu-seleccionado");
		$('#link-tutorial-1').removeClass("menu-seleccionado");
		$('#link-tutorial-2').removeClass("menu-seleccionado");
		$('#link-tutorial-3').removeClass("menu-seleccionado");
		$('#link-tutorial-4').removeClass("menu-seleccionado");
		$('#link-tutorial-5').removeClass("menu-seleccionado");
		$('#link-tutorial-6').removeClass("menu-seleccionado");
		$('#link-tutorial-7').removeClass("menu-seleccionado");
		$('#link-tutorial-8').removeClass("menu-seleccionado");
		$('#link-tutorial-9').removeClass("menu-seleccionado");
		$('#link-tutorial-10').removeClass("menu-seleccionado");
		

	}

  	$( "#ayuda-menu" ).hide();
    $( "#ayuda-menu" ).draggable();
    $( ".cuadro-ayuda" ).hide();
    $( ".cuadro-ayuda" ).draggable();
    $( ".cuadro-tutorial" ).hide();
    $( ".cuadro-tutorial" ).draggable();
    $( ".submenu" ).hide();
    desactivarMenuSeleccionado();

    $('#button-ayuda').click(function(){
		$('#ayuda-menu').show();
		$( ".submenu" ).hide();
		desactivarMenuSeleccionado();
	});

	 $('#cerrar-ayuda').click(function(){
		$('#ayuda-menu').hide();
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$( ".submenu" ).hide();
		desactivarMenuSeleccionado();
		
	});

	$('#link-personajes').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-personajes').show();
		desactivarMenuSeleccionado();
		$('#link-personajes').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	  $('#link-habilidades').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-habilidades').show();
		desactivarMenuSeleccionado();
		$('#link-habilidades').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-partido').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-partido').show();
		desactivarMenuSeleccionado();
		$('#link-partido').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-participar').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-participar').show();
		desactivarMenuSeleccionado();
		$('#link-participar').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-objetivo').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-objetivo').show();
		desactivarMenuSeleccionado();
		$('#link-objetivo').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-asistir-partido').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-asistir-partido').show();
		desactivarMenuSeleccionado();
		$('#link-asistir-partido').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-desarrollo-partido').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#ayuda-desarrollo-partido').show();
		desactivarMenuSeleccionado();
		$('#link-desarrollo-partido').addClass("menu-seleccionado");
		$( ".submenu" ).hide();
	});

	$('#link-tutorial-0').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-0').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-0').addClass("menu-seleccionado");
		$( ".submenu" ).show();
	});

	$('#link-tutorial-1').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-1').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-1').addClass("menu-seleccionado");
	});

	$('#link-tutorial-2').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-2').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-2').addClass("menu-seleccionado");
	});

	$('#link-tutorial-3').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-3').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-3').addClass("menu-seleccionado");
	});

	$('#link-tutorial-4').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-4').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-4').addClass("menu-seleccionado");
	});

	$('#link-tutorial-5').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-5').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-5').addClass("menu-seleccionado");
	});

	$('#link-tutorial-6').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-6').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-6').addClass("menu-seleccionado");
	});

	$('#link-tutorial-7').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-7').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-7').addClass("menu-seleccionado");
	});

	$('#link-tutorial-8').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-8').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-8').addClass("menu-seleccionado");
	});

	$('#link-tutorial-9').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-9').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-9').addClass("menu-seleccionado");
	});

	$('#link-tutorial-10').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-10').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-10').addClass("menu-seleccionado");
	});

	$('#link-flecha-01').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-1').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-1').addClass("menu-seleccionado");
	});

	$('#link-flecha-10').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-0').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-0').addClass("menu-seleccionado");
	});

	$('#link-flecha-12').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-2').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-2').addClass("menu-seleccionado");
	});

	$('#link-flecha-21').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-1').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-1').addClass("menu-seleccionado");
	});

	$('#link-flecha-23').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-3').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-3').addClass("menu-seleccionado");
	});

	$('#link-flecha-32').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-2').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-2').addClass("menu-seleccionado");
	});
	$('#link-flecha-34').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-4').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-4').addClass("menu-seleccionado");
	});

	$('#link-flecha-43').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-3').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-3').addClass("menu-seleccionado");
	});
	$('#link-flecha-45').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-5').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-5').addClass("menu-seleccionado");
	});
	$('#link-flecha-54').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-4').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-4').addClass("menu-seleccionado");
	});

	$('#link-flecha-56').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-6').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-6').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-65').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-5').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-5').addClass("menu-seleccionado");
	});
	

	$('#link-flecha-67').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-7').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-7').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-76').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-6').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-6').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-78').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-8').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-8').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-87').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-7').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-7').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-89').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-9').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-9').addClass("menu-seleccionado");
	});

	$('#link-flecha-98').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-8').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-8').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-910').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-10').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-10').addClass("menu-seleccionado");
	});
	
	$('#link-flecha-109').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
		$('#tutorial-9').show();
		desactivarMenuSeleccionado();
		$('#link-tutorial-9').addClass("menu-seleccionado");
	});
	
	
	$('.cerrar-tutorial').click(function(){
		$('.cuadro-ayuda').hide();
		$('.cuadro-tutorial').hide();
	});

	



  });