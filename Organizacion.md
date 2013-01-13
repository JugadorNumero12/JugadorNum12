#JugadorNum12

##Organización del grupo 
=========================

**Nota: los modelos están indicados con +**

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

###Entrega de enero

**Nota: Toda la actividad se centrará en completar la entrega del 22 de enero**

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
