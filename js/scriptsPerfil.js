$(document).ready(function(){
	$("td.barrita").progressbar({max: 1000});
	var maximo = $("td.barrita").progressbar("option", "max");
	console.log(maximo);
});