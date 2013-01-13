#HISTORIAL DE REVISIONES

##Revisión del 12 / 1 / 2013
============================

###Usuarios

####Usuarios.index [COMPLETA]	

####Usuarios.perfil

*Vista*    
```
Cambiar el título de la página por perfil de "nombre del usuario".
No es necesaria la informacion de nick y email, los datos básicos se quedarán con el tipo de personaje, el nivel y el equipo exclusivamente.
Sólo se muestran las habilidades pasivas desbloqueadas, mostrar también las habilidades de partido desbloqueadas; en este listado, cada habilidad con un link a su descripción.
```

*Modificado*
```
Al hacer el render, se pasaban 4 variables cuando en la vista solo se utiliza modeloU y accionesPas. Se han eliminado los modelos no utilizados.
En la vista ahora se utilizan las constantes para los personajes (definidas en el modelo de usuarios).
```

####Usuarios.ver

*Modificado*
```
En la vista ahora se utilizan las constantes para los personajes (definidas en el modelo de usuarios).
Al hacer el render, se pasaban 2 variables cuando en la vista solo se utiliza modeloU. Se han eliminado los modelos no utilizados.
```

####Usuarios.cuenta

*Vista*
```
Cambiar la implementación de los botones. Hacer uso de la clase de Yii <CHTML::Button>.
La información de cómo hacerlo está en <http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1> 
```

####Usuarios.cambiarClave

*Modelo*
```
Revisar la expresion regular que valida las claves; una clave válida tendrá numeros o letras (mayúsculas o minúsculas) o "_" y tendrá entre 6 y 20 caracteres.
```

####Usuarios.cambiar email [COMPLETA]

###Equipos

####Equipos.index

*Controlador*
```
Al hacer la búsqueda del modelo, añadir un "order by" para que te devuelva los resultados por orden de la posición. No llegarán dos equipos con la misma posición.
```

####Equipos.ver 

*Controlador*
```
Falta funcionalidad: para cualquier equipo, encontrar la lista de jugadores que tiene ese equipo.
```

*Vista*
```
En forma de tabla, añadir la lista de jugadores que pertenecen al equipo (lista que aún no está implementada). Mostrar el nombre del jugador (con enlace a su perfil de usuario), nivel y tipo de personaje.
En la vista de tu propio equipo si hay acciones grupales abiertas; cambiar la vista por una tabla de acciones en la que no se va a imprimir el id del jugador sino el link a la accion grupal (sobre el nombre de la accion abierta), el creador de la accion (con link a su perfil de jugador) y cuántos usuarios hay ya participando en esa accion.
Añadir el botón para cambiar de equipo. Hacer uso de la clase de Yii <CHTML::Button>.
La información de cómo hacerlo está en <http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1> 
```

####Equipos.cambiar [NO FUNCIONA]

*Modificado*
```
Se ha eliminado la transacción. 
```

*Controlador*
```
Falta un "save" para guardar el nuevo registro.
Falta un "if" que compruebe que no se intenta cambiar a tu propio equipo. 
Cambiar la variable de sesion "userAfic" por el id del nuevo equipo.
Expulsar al jugador de todas las acciones grupales en las que está participando actualmente.
```

*Modelo*
```
Hay que añadir "rules" para validar que el nuevo equipo al que se cambia es un equipo existente en la base de datos
```

###Acciones

####Acciones.index

*Vista*
```
Mostrar solo las habilidades grupales e individuales (Ni las de partido ni las pasivas).
Cambiar los destinos del enlace y del botón; tiene que quedar que el nombre de la habilidad te lleva a ver la habilidad, y el botón (en el que pondrá usar habilidad te lleva a usar la habilidad.
Cambiar los botones haciendo uso de la clase de Yii <CHTML::Button>.
La información de cómo hacerlo está en <http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1>
```

####Acciones.usar [NO FUNCIONA]

*Controlador*
```
Revisar la secuencia de "if", en apariencia están justo al revés.
No hay que usar <Yii::app()->user->id> para coger el id del usuario sino <Yii::app()->user->usIdent>
Revisión general de esta función, se considera sin hacer.
```

*Vista*
```
Sin comprobar. No hacer nada hasta que la función esté completada
```

####Acciones.ver

*Controlador*
```
Comprobar que se pide mostrar una accion del equipo del usuario (no permitir ver acciones de otros equipos).
Pasar a la vista la información de los usuarios participantes. 
```

*Modelo*
```
Comprobar que se pide mostrar una accion grupal que existe. 
```

*Vista*
```
Al mostrar la lista de usuarios participantes, mostrar el nombre del usuario, no el id del usuario (habrá que pasar esta información desde el controlador).
Además, no poner el botón de expulsar al propio creador de la accion.
```

####Acciones.participar [POR COMPROBAR]

*Controlador*
```
La transacción tiene que bloquear solo la tabla participaciones (que  no bloque la de habilidades, usuarios y participaciones). Es decir, colocar la linea de código justo antes de "$participacion = new Participaciones;"
```

**Nota: Función sin revisar por no disponer del código actualizado.*

####Acciones.expulsar

*Controlador*
```
Falta la comprobación de que no se está expulsando al propio jugador (que es el creador de la acción).
```

###Habilidades

####Habilidades.index 

*Controlador*
```
Falta contemplar las habildiades pasivas y las de partido. Estamos mostrando el árbol completo. 
```

*Vista*
```
Mostrar el árbol completo (falta información del controlador).
Cambiar la información que se muestra en cada habilidad, mostrar el nombre (hecho), tipo de acción que es (la relación número - tipo está en constantes Habilidades::TIPO_N) y si está desbloqueada. No mostrar los recursos.
```

####Habilidades.ver

*Controlador*
```
Faltan por contemplar las habilidades pasivas y las de partido
```

*Vista*
```
Falta el botón para adquirir la habilidad, hacer uso de la clase de Yii <CHTML::Button>
La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código)
Añadir a la información que se muestra toda la informacion que hay en la base de datos para acciones grupales. (Aclaración: una acción no grupal, en las columnas con información propia de las acciones grupales hay valor "NULL")
```

*Modelo*
```
Comprobar que se pide mostrar una habilidad que existe.
```

####Habilidades.adquirir [COMPLETA]

###Partidos [PENDIENTE DE REVISION]

####Partidos.asistir

**Nota: Solo mostrar una pantalla con el texto "has asistido al partido p del equipo e"; La funcionalidad escrita en asistir pertenece a previa.**

###Registro [PENDIENTE DE REVISIÓN]
