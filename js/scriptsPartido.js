function fmtTime (seconds) {
  var s = Math.floor(seconds%60);
  var m = Math.floor(seconds/60);

  return (m<10 ? '0'+m : m) + ':' + (s<10 ? '0'+s : s);
}

function updateData (recalc,redraw) {
  $('#partido-tiempo').text(fmtTime(partido.tiempo));
  //$('#partido-tiempo-turno').text(fmtTime(partido.tiempoTurno));
  $('#partido-goles-local').text(partido.golesLocal);
  $('#partido-goles-visit').text(partido.golesVisit);

  //Rellenar crónica
  $('#pre-c-p').text(partido.cronica);

  //Rellenar datos
  var datosPr =
    "<b>Turno: </b>"+partido.turno+"</br>"+
    "<b>Estado: </b>"+partido.estado+"</br>"+
    "<b>Ambiente: </b>"+partido.ambiente+"</br>"+
    "<b>Nivel local: </b>"+partido.nivel_local+"</br>"+
    "<b>Nivel visitante: </b>"+partido.nivel_visitante+"</br>"+
    "<b>Indice ofensivo local: </b>"+partido.ofensivo_local+"</br>"+
    "<b>Indice ofensivo visitante: </b>"+partido.ofensivo_visitante+"</br>"+
    "<b>Indice defensivo local: </b>"+partido.defensivo_local+"</br>"+
    "<b>Indice defensivo visitante: </b>"+partido.defensivo_visitante+"</br>"+
    "<b>Aforo local: </b>"+partido.aforo_local+"</br>"+
    "<b>Aforo visitante: </b>"+partido.aforo_visitante+"</br>"+
    "<b>Moral local: </b>"+partido.moral_local+"</br>"+
    "<b>Moral visitante: </b>"+partido.moral_visitante+"</br>";
  $('#partido-info-datos-numeritos').html(datosPr);

  var difmor = Math.min(Math.max((partido.moral_local - partido.moral_visitante) / 300, -1), 1);
  $('#datos-morales .datos-num-local').text(partido.moral_local);
  $('#datos-morales .datos-num-visit').text(partido.moral_visitante);
  $('#datos-morales .datos-barra-local').css({width: (0.5 + (0.48*difmor))*100 + '%'});
  $('#datos-morales .datos-barra-visit').css({width: (0.5 - (0.48*difmor))*100 + '%'});

  $('#datos-ofensivos .datos-num-local').text(partido.ofensivo_local);
  $('#datos-ofensivos .datos-num-visit').text(partido.ofensivo_visitante);
  $('#datos-ofensivos .datos-barra-local').css({width: ((0.5 * Math.min(partido.ofensivo_local, 25) / 25)*100) + '%' });
  $('#datos-ofensivos .datos-barra-visit').css({width: ((0.5 * Math.min(partido.ofensivo_visitante, 25) / 25)*100) + '%'});

  $('#datos-defensivos .datos-num-local').text(partido.defensivo_local);
  $('#datos-defensivos .datos-num-visit').text(partido.defensivo_visitante);
  $('#datos-defensivos .datos-barra-local').css({width: ((0.5 * Math.min(partido.defensivo_local, 25) / 25)*100) + '%' });
  $('#datos-defensivos .datos-barra-visit').css({width: ((0.5 * Math.min(partido.defensivo_visitante, 25) / 25)*100) + '%'});

  for (var t = info.turnos.inicial; t <= info.turnos.final; t++) {
    var turnoDiv = $('#partido-turno-'+ t);
    turnoDiv.removeClass('turno-anterior turno-actual turno-siguiente');
    if (t < partido.turno) {
      turnoDiv.addClass('turno-anterior');

    } else if (t > partido.turno) {
      turnoDiv.addClass('turno-siguiente');

    } else {
      turnoDiv.addClass('turno-actual');
    }
  }

  for (var a in window.acciones) {
    var acc = window.acciones[a];

    if (acc.cooldown > 0) {
      window.acciones[a].cooldown = acc.until - (new Date()).getTime();
      $('#cooldown-' + a).text(Math.ceil(acc.cooldown/1000));
      $('#accion-' + a).addClass('disabled');

    } else {
      $('#cooldown-' + a).text('');
      if (!acc.ajax) {
        $('#accion-' + a).removeClass('disabled');
      }
      window.acciones[a].enabled = true;
    }
  }

  if (redraw) {
    updateDrawing();
  }

  if (recalc) {
    updateState(partido.estado);
  }
}

function updateDrawing () {
  var img = $('#partido-dibujo-imagen');

  // Los equipos en el orden que aparecen en la carpeta
  var swapped = false;
  var teams = [partido.equipos.local.token, partido.equipos.visitante.token];
  if (teams[0] > teams[1]) {
    swapped = true;

    var tmp = teams[0];
    teams[0] = teams[1];
    teams[1] = tmp;
  }

  // El estado actual, atendiendo al orden modificado
  var state = (swapped) ? -partido.estado : partido.estado;

  imgurl = baseUrl + '/images/dibujos_partido/' + teams[0] + '_' + teams[1] + '/estado_' + state + '.jpg';
  console.log(imgurl);

  img.show();
  img.attr('src', imgurl);
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

  $('#partido-info-tabs li, #partido-info-tabs li a').click(function(evt){
    $(this).removeClass('highlight highlight-high highlight-low');
    $(this).parent().removeClass('highlight highlight-high highlight-low');
  });

  // Control del partido
  if (window.partido) {
    partido.ajax = false;

    // Actualiza los tiempos
    setInterval(function(){
      var hlh = $('.highlight-high');
      var hll = $('.highlight-low');
      hlh.addClass('highlight highlight-low').removeClass('highlight-high');
      hll.addClass('highlight highlight-high').removeClass('highlight-low');
      $('ui-state-selected').removeClass('highlight highlight-low highlight-high');

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
            var golLocAct = partido.golesLocal;
            var golVisAct = partido.golesVisit;

            $.extend(partido, JSON.parse(data));

            var recalc = turnoAct != partido.turno;
            updateData(recalc, recalc);

            if (golLocAct != partido.golesLocal || golVisAct != partido.golesVisit) {
              (function(){})(); // TODO Goles
            }

            // Si el servidor dice que el partido ya se ha acabado, redirigimos a la crónica
            // NUNCA antes
            if (partido.turno > info.turnos.final && partido.tiempo <= 0) {
              // window.location = baseUrl + '/partidos/cronica?id_partido=' + partido.id;
              window.location = baseUrl + '/partidos/index';
            }

          }).always(function(){
            partido.ajax = false;
          });
        }
      }

      updateData(false, false);
    }, 1000);
  }

  updateData(true, true);

  // Función para ocultar div de errores
  $("#tabs-mensaje").click(function (){
    $("#tabs-mensaje").css({opacity: 0});
  });
});

// Funcion para realizar acciones de partido por ajax
function ejecutarAP (id) {
  // Solo realizamos petición AJAX si no se está realizando ya
  if (!window.acciones[id].ajax && window.acciones[id].enabled) {
    window.acciones[id].ajax = true;
    window.hideTag = -1;
    $("#tabs-mensaje").css({opacity: 0.3});
    $("#tabs-mensaje").text('...');
    $('#accion-' + id).addClass('disabled');

    $.ajax({
      url: baseUrl + '/acciones/usarpartido?id_accion=' + id

    }).done(function(data,status){
      var json = JSON.parse(data);
      if (json.ok) {
        $("#tabs-mensaje").text(json.message);
        actRecursosAj();

      } else {
        if (!json.cooldownEnd) {
          $('#accion-' + id).removeClass('disabled');
        }
        $("#tabs-mensaje").text(json.error);
      }

      if (json.cooldownEnd) {
        var cEnd = json.cooldownEnd * 1000;
        var now = (new Date()).getTime();

        window.acciones[id].enabled = false;
        window.acciones[id].until = cEnd;
        window.acciones[id].cooldown = cEnd - now;
        $('#cooldown-' + id).text(Math.ceil((cEnd-now)/1000));
        $('#accion-' + id).addClass('disabled');
        /*setTimeout(function(){
          window.acciones[id].enabled = true;
          $('#accion-' + id).removeClass('disabled');
        }, cEnd - now);*/
      }

      $("#tabs-mensaje").css({opacity: 1});
    
      var tag = (new Date()).getTime();
      window.hideTag = tag;
      setTimeout(function(){
        if (window.hideTag == tag) {
          $("#tabs-mensaje").css({opacity: 0});
        }
      }, 2500);
    }).always(function(){

      window.acciones[id].ajax = false;
    });
  }
}
