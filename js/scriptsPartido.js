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

// --------------------------------------------------------------------------------

/**
 * Devuelve un objeto con dos campos, 'visits' y 'locals', ambos arrays de puntos.
 *
 * Cada punto es un objeto con dos campos, 'x' e 'y', que indican, respectivamente:
 *
 * - La posición horizontal de la marca de jugador, siendo 0 la portería propia,
 *   1 el centro del campo y 2 la poteria contraria
 * - La posición vertical de la marcade jugador, siendo 0 el centro del campo,
 *   +1 el lateral derecho y -1 el lateral izquierdo
 *
 * Funciones auxiliares para la colocacion de puntos
 *
 * - function porteroColocado()
 * - function porteroAdelantado()
 * - function lineaDefensivaAtrasada() 
 * - function lineaDefensivaAdelantada() 
 * - function centroCampistasColocados() 
 * - function centroCampistasAdelantados() 
 * - function delanterosColocados() 
 *
 * @param state (Se considera que se llamara con un estado correcto [-10, 10])
 * @return [{x, y}]
 */
function posiciones (state) {
  var pos = {locals: [], visits: []};
  
  if (state < -7) {
    pos.locals = pos.locals.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAtrasados(),
        delanterosAtrasados()
    );
    pos.visits = pos.visits.concat(
        porteroAdelantado(),
        lineaDefensivaAdelantada(),
        centroCampistasAdelantados(),
        delanterosAdelantados()
    );
  } else if (state < -4) {
    pos.locals = pos.locals.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAtrasados(),
        delanterosColocados()
    );
    pos.visits = pos.visits.concat(
        porteroAdelantado(),
        lineaDefensivaAdelantada(),
        centroCampistasColocados(),
        delanterosAdelantados()
    );
  } else if (state < -1) {
    pos.locals = pos.locals.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasColocados(),
        delanterosAtrasados()
    );
    pos.visits = pos.visits.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasColocados(),
        delanterosAtrasados()
    );
  } else if (state < 1) {
    pos.locals = pos.locals.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasColocados(),
        delanterosColocados()
    );
    pos.visits = pos.visits.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasColocados(),
        delanterosColocados()
    );
  } else if (state < 4) {
    pos.locals = pos.locals.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAdelantados(),
        delanterosColocados()
    );
    pos.visits = pos.visits.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAtrasados(),
        delanterosColocados()
    );
  } else if (state < 7) {
    pos.locals = pos.locals.concat(
        porteroAdelantado(),
        lineaDefensivaAdelantada(),
        centroCampistasColocados(),
        delanterosAdelantados()
    );
    pos.visits = pos.visits.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAtrasados(),
        delanterosColocados()
    );
  } else {
    pos.locals = pos.locals.concat(
        porteroAdelantado(),
        lineaDefensivaAdelantada(),
        centroCampistasAdelantados(),
        delanterosAdelantados()
    );
    pos.visits = pos.visits.concat(
        porteroColocado(),
        lineaDefensivaAtrasada(),
        centroCampistasAtrasados(),
        delanterosAtrasados()
    );
  }

  return pos;
}

/** 
 * Devuelve un punto aleatorio aproximado al dado por parametro
 *
 * Aproxima con un numero aleatorio (1- 10) / 100
 *
 * @param x
 * @param y
 * @return {x, y}
 */
function ptoAleatorio(x, y) {
  var xr = x;
  var yr = y;
  
  operacion = Math.random();
  if (operacion <= 0.5) {
    xr = xr + ( Math.floor((Math.random()*10)+1) ) / 200;
  } else {
    xr = xr - ( Math.floor((Math.random()*10)+1) ) / 200;
  } 

  operacion = Math.random();
  if (operacion <= 0.5) {
    yr = yr + ( Math.floor((Math.random()*10)+1) ) / 200;
  } else {
    yr = yr - ( Math.floor((Math.random()*10)+1) ) / 200;
  }

  return {x: xr, y: yr};
}

/**
 * Devuelve un punto fijo para el portero
 *
 * @return {x, y}
 */
function porteroColocado(){ return [{x: 0.1, y: 0}]; }

/**
 * Devuelve un punto aleatorio cercano al medio del campo
 */
function porteroAdelantado(){ return [ptoAleatorio( 0.6, 0 )]; }

/**
 * Devuelve 4 puntos que representan los defensas atrasados
 *
 * @return [{x, y}]
 */
function lineaDefensivaAtrasada() {
  var li =  ptoAleatorio( 0.3,  -0.65);
  var ct1 =  ptoAleatorio( 0.25, -0.2);
  var ct2 =  ptoAleatorio( 0.25, 0.2);
  var ld =  ptoAleatorio( 0.3,  0.65);
  return [li, ct1, ct2, ld];
}

/**
 * Devuelve 4 puntos que representan los defensas adelantados
 *
 * @return [{x, y}]
 */
function lineaDefensivaAdelantada() {
  var li =   ptoAleatorio( 0.8,  -0.8);
  var ct1 =  ptoAleatorio( 0.3, -0.1);
  var ct2 =  ptoAleatorio( 0.8, 0.3);
  var ld =   ptoAleatorio( 1,  0.8);
  return [li, ct1, ct2, ld];
}

/**
 * Devuelve 4 puntos que representan los centro campistas atrasados
 *
 * @return [{x, y}]
 */
function centroCampistasAtrasados(){
  var mc = ptoAleatorio( 0.5, 0.15 );
  var mp = ptoAleatorio( 0.6, -0.2 );
  var ii = ptoAleatorio( 0.75, -0.65 );
  var id = ptoAleatorio( 0.75, 0.65 );
  return [mc, mp, ii, id];
}

/**
 * Devuelve 4 puntos que representan los centro campistas colocados
 *
 * @return [{x, y}]
 */
function centroCampistasColocados() {
  var mc = ptoAleatorio( 0.7, 0.1 );
  var mp = ptoAleatorio( 0.9, -0.25 );
  var ii = ptoAleatorio( 1.25, -0.75 );
  var id = ptoAleatorio( 1.25, 0.75 );
  return [mc, mp, ii, id];
}

/**
 * Devuelve 4 puntos que representan los centro campistas adelantados
 *
 * @return [{x, y}]
 */
function centroCampistasAdelantados() {
  var mc = ptoAleatorio( 1.2, 0 );
  var mp = ptoAleatorio( 1.4, -0.4 );
  var ii = ptoAleatorio( 1.7, -0.8 );
  var id = ptoAleatorio( 1.7, 0.8 );
  return [mc, mp, ii, id]; 
}

/**
 * Devuelve 2 puntos que representan los delanteros colocados atrasados
 *
 * @return [{x, y}]
 */
function delanterosAtrasados() {
  var sp = ptoAleatorio( 1, -0.45 );
  var dc = ptoAleatorio( 1.3, 0.1 );
  return [sp, dc];
}

/**
 * Devuelve 2 puntos que representan los centro delanteros colocados
 *
 * @return [{x, y}]
 */
function delanterosColocados() {
  var sp = ptoAleatorio( 1.35, -0.4 );
  var dc = ptoAleatorio( 1.5, 0.2 );
  return [sp, dc];
}

/**
 * Devuelve 2 puntos que representan los centro delanteros adelantados
 *
 * @return [{x, y}]
 */
function delanterosAdelantados() {
  var sp = ptoAleatorio( 1.55, 0.5);
  var dc = ptoAleatorio( 1.7, 0.1);
  return[sp, dc];
}

// --------------------------------------------------------------------------------

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
            var turnoAct = partido.turno;
            $.extend(partido, JSON.parse(data));
            updateData(turnoAct != partido.turno);

            if (partido.tiempo <= 0) {
              window.location = baseUrl + '/partidos/previa?id_partido=' + partido.id;
            }

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