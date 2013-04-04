$(document).ready(function(){
  $("img.escudos-clasificacion").hover(function(){
    var texto = $("img.escudos-clasificacion").val();
	$("img.escudos-clasificacion").show(texto);
  });

  	var valorDinero = parseInt(document.getElementById("barrasup-progressbar-dinero").getAttribute("data-valor"));
	$("#barrasup-progressbar-dinero").progressbar({value: valorDinero, max: valorDinero});

	var maxAnimo = parseInt(document.getElementById("barrasup-progressbar-animo").getAttribute("data-max"));
	$("#barrasup-progressbar-animo").progressbar({max: maxAnimo});
	var valorAnimo = parseInt(document.getElementById("barrasup-progressbar-animo").getAttribute("data-valor"));
	$("#barrasup-progressbar-animo").progressbar({value: valorAnimo});

	var maxInflu = parseInt(document.getElementById("barrasup-progressbar-influencias").getAttribute("data-max"));
	$("#barrasup-progressbar-influencias").progressbar({max: maxInflu});
	var valorInflu = parseInt(document.getElementById("barrasup-progressbar-influencias").getAttribute("data-valor"));
	$("#barrasup-progressbar-influencias").progressbar({value: valorInflu});


	var labelDinero = $("#progressbar-label-dinero");
	labelDinero.text($("#barrasup-progressbar-dinero").progressbar("value"));
	var labelAnimo = $("#progressbar-label-animo");
	labelAnimo.text($("#barrasup-progressbar-animo").progressbar("value") + "/"+ $("#barrasup-progressbar-animo").progressbar("option", "max"));
	var labelInfluencias = $("#progressbar-label-influencias");
	labelInfluencias.text($("#barrasup-progressbar-influencias").progressbar("value") + "/"+ $("#barrasup-progressbar-influencias").progressbar("option", "max"));
});