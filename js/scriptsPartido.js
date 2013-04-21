function fmtTime (seconds) {
  var s = Math.floor(seconds%60);
  var m = Math.floor(seconds/60);

  return (m<10 ? '0'+m : m) + ':' + (s<10 ? '0'+s : s);
}

function updateData (recalc) {
  $('#partido-tiempo').text(fmtTime(partido.tiempo));
  $('#partido-tiempo-turno').text(fmtTime(partido.tiempoTurno));
  $('#partido-goles-local').text(partido.golesLocal);
  $('#partido-goles-visit').text(partido.golesVisit);
  if (recalc) {
    updateState(partido.estado);
  }
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
  var mh = $(locals[0]).height();
  var mw = $(locals[0]).width();

  var height = $(campo).height() - mh;
  var width = $(campo).width() - mw;

  var pos = posiciones(state, width, height);
  for ( var i = 0; i < 11; i++ ) {
    $(locals[i]).css({
      top:  (height/2) * (pos.locals[i].y + 1),
      left: pos.locals[i].x * width / 2
    });
    $(visits[i]).css({
      bottom: (height/2) * (pos.visits[i].y + 1),
      right:  pos.visits[i].x * width / 2
    });
  }
}

/**
 * Devuelve un objeto con dos campos, 'visits' y 'locals', ambos arrays de puntos.
 * Cada punto es un objeto con dos campos, 'x' e 'y', que indican, respectivamente:
 * - La posición horizontal de la marca de jugador, siendo 0 la portería propia,
 *   1 el centro del campo y 2 la poteria contraria
 * - La posición vertical de la marcade jugador, siendo 0 el centro del campo,
 *   +1 el lateral derecho y -1 el lateral izquierdo
 */
function posiciones (state) {
  var pos = {locals: [], visits: []};
  for ( var i = 0; i < 11; i++ ) {
    pos.locals.push({x: Math.random(), y: Math.random()*2-1});
    pos.visits.push({x: Math.random(), y: Math.random()*2-1});
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
            updateData(true);

          }).always(function(){
            partido.ajax = false;
          });
        }
      }

      updateData(false);
    }, 1000);
  }

  updateData(true);
});