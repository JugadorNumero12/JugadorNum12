$(document).ready(function(){
  $("img.escudos-clasificacion").hover(function(){
    var texto = $("img.escudos-clasificacion").val();
	$("img.escudos-clasificacion").show(texto);
  });

  	var maxAnimo = parseInt(document.getElementById("bar").getAttribute("data-max"));
	$("td#bar").progressbar({max: maxAnimo});
	var valorAnimo = parseInt(document.getElementById("bar").getAttribute("data-valor"));
	$("td#bar").progressbar({value: valorAnimo});

	var maxInflu = parseInt(document.getElementById("bar2").getAttribute("data-max"));
	$("td#bar2").progressbar({max: maxInflu});
	var valorInflu = parseInt(document.getElementById("bar2").getAttribute("data-valor"));
	$("td#bar2").progressbar({value: valorInflu});

	var label1 = $(".label1");
	label1.text($("td#bar").progressbar("value") + "/"+ $("td#bar").progressbar("option", "max"));
	var label2 = $(".label2");
	label2.text($("td#bar2").progressbar("value") + "/"+ $("td#bar2").progressbar("option", "max"));
});