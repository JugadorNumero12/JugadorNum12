CREATE TABLE acciones_grupales (
  id_accion_grupal INT UNSIGNED NOT NULL AUTO_INCREMENT,
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  habilidades_id_habilidad INT UNSIGNED NOT NULL,
  equipos_id_equipo INT UNSIGNED NOT NULL,
  influencias_acc INT UNSIGNED NOT NULL,
  animo_acc INT UNSIGNED NOT NULL,
  dinero_acc INT UNSIGNED NOT NULL,
  jugadores_acc INT UNSIGNED NOT NULL,
  finalizacion INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY(id_accion_grupal),
  INDEX acciones_grupales_FKIndex1(equipos_id_equipo),
  INDEX acciones_grupales_FKIndex3(habilidades_id_habilidad),
  INDEX acciones_grupales_FKIndex2(usuarios_id_usuario)
);

CREATE TABLE acciones_individuales (
  habilidades_id_habilidad INT UNSIGNED NOT NULL,
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  cooldown INT(11) UNSIGNED NOT NULL,
  INDEX acciones_individuales_FKIndex1(usuarios_id_usuario),
  INDEX acciones_individuales_FKIndex2(habilidades_id_habilidad)
);

CREATE TABLE acciones_turno (
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  habilidades_id_habilidad INT UNSIGNED NOT NULL,
  partidos_id_partido INT UNSIGNED NOT NULL,
  equipos_id_equipo INT UNSIGNED NOT NULL,
  turno SMALLINT UNSIGNED NOT NULL,
  INDEX acciones_turno_FKIndex3(equipos_id_equipo),
  INDEX acciones_turno_FKIndex4(partidos_id_partido),
  INDEX acciones_turno_FKIndex2(habilidades_id_habilidad),
  INDEX acciones_turno_FKIndex1(usuarios_id_usuario)
);

CREATE TABLE clasificacion (
  equipos_id_equipo INT UNSIGNED NOT NULL,
  posicion INT UNSIGNED NOT NULL,
  puntos INT UNSIGNED NOT NULL,
  ganados INT UNSIGNED NOT NULL,
  empatados INT UNSIGNED NOT NULL,
  perdidos INT UNSIGNED NOT NULL,
  PRIMARY KEY(equipos_id_equipo),
  INDEX Clasificacion_FKIndex1(equipos_id_equipo)
);

CREATE TABLE desbloqueadas (
  habilidades_id_habilidad INT UNSIGNED NOT NULL,
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  INDEX desbloqueadas_FKIndex1(usuarios_id_usuario),
  INDEX desbloqueadas_FKIndex2(habilidades_id_habilidad)
);

CREATE TABLE equipos (
  id_equipo INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  categoria INT UNSIGNED NOT NULL,
  aforo_max INT UNSIGNED NOT NULL,
  aforo_base INT UNSIGNED NOT NULL,
  nivel_equipo SMALLINT UNSIGNED NOT NULL,
  factor_ofensivo INT UNSIGNED NOT NULL,
  factor_defensivo INT UNSIGNED NOT NULL,
  PRIMARY KEY(id_equipo)
);

CREATE TABLE habilidades (
  id_habilidad INT UNSIGNED NOT NULL AUTO_INCREMENT,
  codigo INT UNSIGNED NOT NULL,
  PRIMARY KEY(id_habilidad)
);

CREATE TABLE participaciones (
  acciones_grupales_id_accion_grupal INT UNSIGNED NOT NULL,
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  dinero_aportado INT UNSIGNED NOT NULL,
  influencias_aportadas INT UNSIGNED NOT NULL,
  animo_aportado INT UNSIGNED NOT NULL,
  INDEX participantes_FKIndex1(usuarios_id_usuario),
  INDEX participaciones_FKIndex2(acciones_grupales_id_accion_grupal)
);

CREATE TABLE partidos (
  id_partido INT UNSIGNED NOT NULL AUTO_INCREMENT,
  equipos_id_equipo_1 INT UNSIGNED NOT NULL,
  equipos_id_equipo_2 INT UNSIGNED NOT NULL,
  hora INT(11) UNSIGNED NOT NULL,
  cronica TEXT NOT NULL,
  PRIMARY KEY(id_partido),
  INDEX partidos_FKIndex1(equipos_id_equipo_1),
  INDEX partidos_FKIndex2(equipos_id_equipo_2)
);

CREATE TABLE recursos (
  usuarios_id_usuario INT UNSIGNED NOT NULL,
  dinero INT UNSIGNED NOT NULL,
  dinero_gen FLOAT NOT NULL,
  influencias INT UNSIGNED NOT NULL,
  influencias_max INT UNSIGNED NOT NULL,
  influencias_gen FLOAT NOT NULL,
  animo INT UNSIGNED NOT NULL,
  animo_max INT UNSIGNED NOT NULL,
  animo_gen FLOAT NOT NULL,
  INDEX recursos_FKIndex1(usuarios_id_usuario)
);

CREATE TABLE usuarios (
  id_usuario INT UNSIGNED NOT NULL AUTO_INCREMENT,
  equipos_id_equipo INT UNSIGNED NOT NULL,
  nick VARCHAR(45) NOT NULL,
  pass VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  personaje SMALLINT UNSIGNED NULL,
  nivel INT UNSIGNED NULL,
  PRIMARY KEY(id_usuario),
  INDEX usuarios_FKIndex1(equipos_id_equipo)
);


