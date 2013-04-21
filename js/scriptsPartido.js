function fmtTime (seconds) {
  var s = Math.floor(seconds%60);
  var m = Math.floor(seconds/60);

  return (m<10 ? '0'+m : m) + ':' + (s<10 ? '0'+s : s);
}

function updateData () {
  $('#partido-tiempo').text(fmtTime(partido.tiempo));
  $('#partido-tiempo-turno').text(fmtTime(partido.tiempoTurno));
  $('#partido-goles-local').text(partido.golesLocal);
  $('#partido-goles-visit').text(partido.golesVisit);
}

$(document).ready(function(evt){
  // Sstema de pestañas
  $('#partido-info').tabs();
  $('#partido-info').removeClass('ui-corner-all ui-widget-content');

  // Control del partido
  if (window.partido) {
    partido.ajax = false;

    // Actualiza los tiempos
    setInterval(function(){
      if (partido.tiempo > 0) {
        partido.tiempo--;
      }

      if (partido.tiempoTurno > 0) {
        partido.tiempoTurno--;

      } else if (partido.tiempoTurno === 0) {
        if (!partido.ajax) {
          partido.ajax = true;

          $.ajax({
            url: baseUrl + '/partidos/actpartido?id_partido=' + partido.id

          }).done(function(data,status){
            $.extend(partido, JSON.parse(data));
            updateData();

          }).always(function(){
            partido.ajax = false;
          });
        }
      }

      updateData();
    }, 1000);
  }
});