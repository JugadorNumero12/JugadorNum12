#JugadorNum12
============

###Historial de revisiones 
*(los modelos estan indicados con +)*


1. Diciembre

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

	===================	
	
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

2. Navidades
	
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

	===================	

	**Alex** 
	```
	components/Partido.contructora
	components/Partido.cargaEstado
	components/Partido.guardaEstado
	components/Partido.inicializarEncuentro
	functional/ .php
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

3. Enero

	**FUTURO**