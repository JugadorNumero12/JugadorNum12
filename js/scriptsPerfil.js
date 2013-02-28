$(document).ready(function(){
	var maxAnimo = parseInt(document.getElementById("bar").getAttribute("data-max"));
	$("td#bar").progressbar({max: maxAnimo});
	var valorAnimo = parseInt(document.getElementById("bar").getAttribute("data-valor"));
	$("td#bar").progressbar({value: valorAnimo});

	var maxInflu = parseInt(document.getElementById("bar2").getAttribute("data-max"));
	$("td#bar2").progressbar({max: maxInflu});
	var valorInflu = parseInt(document.getElementById("bar2").getAttribute("data-valor"));
	$("td#bar2").progressbar({value: valorInflu});
});