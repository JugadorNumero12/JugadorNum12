JugadorNum12
============

Historial de revisiones (los modelos estan indicados con *)


Diciembre

	Controladores
		Usuarios: Alex, Marina, Rober
		Registro: Alex
		Equipos:  Marina, Sam
		Habilidades: Arturo, Dani
		Acciones: Dani, Pedro, Marcos
		Partidos: Marina, Arturo

	Modelos(*)
		Usuarios: Rober
		Recursos: Alex
		Equipos: Sam
		Clasificacion: Marcos
		Habilidades: Arturo
		Acciones individuales: Pedro
		Acciones grupales: Marcos
		Acciones turno: Marcos
		Desbloqueadas: Alex
		Partidos: Sam
		Participaciones: Dani
		
	===================
	
	Alex 
		Registro.index
		Usuarios.cuenta
		Desbloqueadas(*)
		Recursos(*)

	Arturo
		Habilidades.adquirir
		Partidos.index
		Partidos.asistir
		Habilidades(*)

	Dani
		Habilidades.index
		Habilidades.ver
		Acciones.usar
		Participaciones(*)

	Marcos
		Clasificacion(*)
		AccionesGrupales(*)
		AccionesTurno(*)
		Acciones.expulsar

	Marina
		Usuarios.perfil
		Usuarios.ver
		Partidos.previa
		Equipos.index

	Pedro
		Acciones.index
		AccionesIndividuales(*)
		Acciones.ver
		Acciones.participar

	Rober
		Usuarios.index
		Usuarios.cambiarClave
		Usuarios.cambiarEmail
		Usuarios(*)

	Sam
		Equipos.ver
		Equipos.cambiar
		Equipos(*)
		Partidos(*)