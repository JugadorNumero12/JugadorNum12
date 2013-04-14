function fmtTime (seconds) {
  var s = seconds%60;
  var m = seconds/60;

  return (m<10 ? '0'+m : m) + ':' + (s<10 ? '0'+s : s);
}

$(document).ready(function(evt){
  if (partido) {
    var matchTime = $('#partido-tiempo');
    var turnTime = $('#partido-tiempo-turno');

    // Actualiza los tiempos
    setInterval(function(){
      partido.tiempo--;
      partido.tiempoTurno--;

    }, 1000);
  }
});