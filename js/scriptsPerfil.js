$(document).ready(function(){
	var maxAnimo = parseInt(document.getElementById("bar").getAttribute("data-max"));
	$("#bar").progressbar({max: maxAnimo});
	var valorAnimo = parseInt(document.getElementById("bar").getAttribute("data-valor"));
	$("#bar").progressbar({value: valorAnimo});

	var maxInflu = parseInt(document.getElementById("bar2").getAttribute("data-max"));
	$("#bar2").progressbar({max: maxInflu});
	var valorInflu = parseInt(document.getElementById("bar2").getAttribute("data-valor"));
	$("#bar2").progressbar({value: valorInflu});

	var label1 = $(".label1");
	label1.text($("#bar").progressbar("value") + "/"+ $("#bar").progressbar("option", "max"));
	var label2 = $(".label2");
	label2.text($("#bar2").progressbar("value") + "/"+ $("#bar2").progressbar("option", "max"));
});