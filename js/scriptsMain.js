$(document).ready(function(){
  $("img.escudos-clasificacion").hover(function(){
    var texto = $("img.escudos-clasificacion").val();
	$("img.escudos-clasificacion").show(texto);
  });
});