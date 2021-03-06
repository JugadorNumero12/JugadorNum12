#JugadorNum12

##Organización del grupo 
=========================

###15 mayo (fecha no confirmada)

> Proyecto completo

####Perspectiva general

* Juego completo: testeado y balanceado.  
* Presentación de final de curso.  

***

###24 abril (fecha no confirmada)

> 2ª Demo del juego.

####Perspectiva general

* Juego completo (sin balancear ni pruebas finales).  
* Interacción en los partidos.   
* Árbol de habilidades desarrollado.
* Sistema de experiencia mejorado.
* Objetos integrados.
* Arte "básico" del juego terminado. 
* Documentación completada.   

***

###20 marzo

> 1ª Demo del juego.  

####Perspectiva general

* Registro de los usuarios; selección de personaje y afición. 
* Sistema de recursos completado.  
* Desbloquear y usar habilidades individuales y grupales.  
* Capacidad para asistir a un partido (sin interacción en él)
* Capacidad de completar acciones grupales con efecto en el estado inicial de un partio.  
* Liga creada.  
* 1º estado del arte del proyecto
* Documentación: diagrama de clases.
* Documentación: diagrama de secuencia.
* Documentación: casos de uso.

***

###4 - 15 marzo

> Completar la primera Demo del 20 de marzo.  

####Perspectiva general

* Integración de los dibujos en la página.
* Terminar todas las funcionalidades previstas para la demo.
* 1 semana de margen

***

###18 - 28 febrero

> Perfilar la primera Demo del 20 de marzo. 

####Perspectiva general

**Lógica del partido**
* Xaby 
* Rober 
* Marina 

**Fórmula del partido**
* Dani

**Front-end, estilo**
* Pedro
* Sam

**Módulo de actualización de recursos**
* Alex

**Test**
* Arturo

**Subir la página**
* Marcos

***

###Entrega de enero

> Toda la actividad se centrará en completar la entrega del 22 de enero**

####Perspectiva general

**Controladores**
* Equipos.index: Dani
* Equipos.ver: Dani
* Equipos.cambiar: Rober
* Acciones.usar: Arturo
* Acciones.ver: Dani
* Acciones.participar: Marcos
* Acciones.expulsar: Dani
* Habilidades.index: Dani
* Habilidades.ver: Dani
* Partidos.asistir: Manu

**Vistas**
* Usuarios.perfil: Marina, Alex, Pedro
* Usuarios.cuenta: Marina, Alex, Pedro
* Equipos.ver: Marina, Alex, Pedro
* Acciones.index: Marina, Alex, Pedro
* Acciones.usar: Marina, Alex, Pedro
* Acciones.ver: Marina, Alex, Pedro
* Habilidades.index: Marina, Alex, Pedro
* Habilidades.ver: Marina, Alex, Pedro

**Modelos**
* Usuarios+: Sam
* Equipos+: Sam
* Acciones+: Sam
* Habilidades+: Sam


####Organización por personas

**Alex** 
```
* Vistas
```

**Arturo**
```
* Acciones.usar
```

**Dani**
```
* Equipos.index
* Equipos.ver
* Acciones.ver
* Acciones.expulsar
* Habilidades.index
* Habilidades.ver
```

**Marcos**
```
Acciones.participar
```

**Marina**
```
* Vistas
```

**Pedro**
```
* Vistas
```

**Rober**
```
Equipos.cambiar
```

**Sam**
```
* Usuarios+
* Equipos+
* Acciones+
* Habilidades+
```

*** 

###Diciembre

####Perspectiva general

**Controladores**
* Usuarios: Alex, Marina, Rober
* Registro: Alex
* Equipos:  Marina, Sam
* Habilidades: Arturo, Dani
* Acciones: Dani, Pedro, Marcos
* Partidos: Marina, Arturo

**Modelos**
* Usuarios: Rober
* Recursos: Alex
* Equipos: Sam
* Clasificacion: Marcos
* Habilidades: Arturo
* Acciones individuales: Pedro
* Acciones grupales: Marcos
* Acciones turno: Marcos
* Desbloqueadas: Alex
* Partidos: Sam
* Participaciones: Dani

####Organización por personas

**Alex** 
```
Registro.index
Usuarios.cuenta
Desbloqueadas(+)
Recursos(+)
```

**Arturo**
```
Habilidades.adquirir
Partidos.index
Partidos.asistir
Habilidades(+)
```

**Dani**
```
Habilidades.index
Habilidades.ver
Acciones.usar
Participaciones(+)
```

**Marcos**
```
Clasificacion(+)
AccionesGrupales(+)
AccionesTurno(+)
Acciones.expulsar
```

**Marina**
```
Usuarios.perfil
Usuarios.ver
Partidos.previa
Equipos.index
```

**Pedro**
```
Acciones.index
AccionesIndividuales(+)
Acciones.ver
Acciones.participar
```

**Rober**
```
Usuarios.index
Usuarios.cambiarClave
Usuarios.cambiarEmail
Usuarios(+)
```

**Sam**
```
Equipos.ver
Equipos.cambiar
Equipos(+)
Partidos(+)
```

###Navidades

####Perspectiva general

**Componentes**
* Formula: Dani, Pedro
* Helper: Arturo
* Partido: Alex, Marcos
* Scripts: Rober
* Acciones: Arturo, Dani, Marina, Pedro, Rober, Sam

**Data**
* esquema.sql: Arturo, Xaby

**Tests**
* fixtures: Sam
* functional: Sam Alex

**CSS**
* Diseño de la jerarquia: Marina

####Organización por personas	

**Alex** 
```
components/Partido.contructora
components/Partido.cargaEstado
components/Partido.guardaEstado
components/Partido.inicializarEncuentro
functional/UsuariosTest.php
```

**Arturo**
```
data/estructura.sql
components/Acciones/Apostar.php
components/Acciones/PunteroLaser.php
components/Acciones/PromoverPartido.php
```

**Dani**
```
components/Formula.php
components/Acciones/BeberCerveza.php
components/Acciones/HablarSpeaker.php
```

**Marcos**
```
components/Partido.recogeAccionesTurno
components/Partido.generaCronicaTurno
components/Partido.generaBonificacion
components/Partido.actualizaClasificacion
```

**Marina**
```
css/comunes.css
css/divisiones.css
css/perfil.css
components/Acciones/ContratarRRPP.php
```

**Pedro**
```
components/Formula.php
components/Acciones/FinanciarEvento.php
components/Acciones/OrganizarHomenaje.php
components/Partido.generarCronicaBase
```

**Rober**
```
components/ejecutor_turnos.php
components/Helper.php
components/Acciones/RetransmitirRRSS.php
components/Acciones/IniciarOla.php
```

**Sam**
```
fixtures/Equipos.php
fixtures/Usuarios.php
functional/ .php
components/Acciones/IncentivoEconomico.php
```



