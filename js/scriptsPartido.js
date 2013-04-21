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
  updateState(partido.estado);
}

function updateState (state) {
  var campo = $('#js-campo');
  var locals = $('.js-marca-local');
  var visits = $('.js-marca-visit');

  // Eliminar si sobran
  while (locals.length > 11) {
    locals.pop().remove();
  }
  while (visits.length > 11) {
    visits.pop().remove();
  }

  // Añadir si faltan
  while (locals.length < 11) {
    var eltl = $('<div></div>');
    eltl.addClass('js-marca-local');
    campo.append(eltl);
    locals.push(eltl);
  }
  while (visits.length < 11) {
    var eltv = $('<div></div>');
    eltv.addClass('js-marca-visit');
    campo.append(eltv);
    visits.push(eltv);
  }

  // Colocar las marcas
  var pos = posiciones(state, campo.width(), campo.height());
  for ( var i = 0; i < 11; i++ ) {
    locals[i].css({top: pos.locals[i].top, left: pos.locals[i].left});
    visits[i].css({top: pos.visits[i].top, left: pos.visits[i].left});
  }
}

function posiciones (state, width, height) {
  var pos = {locals: [], visits: []};
  for ( var i = 0; i < 11; i++ ) {
    pos.locals.push({top: Math.random()*height, left: Math.random()*(width/2)});
    pos.visits.push({top: Math.random()*height, left: Math.random()*(width/2) + width/2});
  }
  return pos;
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