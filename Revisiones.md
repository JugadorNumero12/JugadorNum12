#HISTORIAL DE REVISIONES

##REVISION 12 ENERO 2013

###Usuarios

Usuarios.index 	

Usuarios.perfil
    Cambiar el título de la página por 
    perfil de "nombre del usuario"

    No es necesaria la informacion de nick y email, los datos básicos se quedarán con el tipo de personaje, el nivel y el equipo exclusivamente

    Modificado: Al hacer el render, se pasan 4 variables cuando en la vista solo se utiliza modeloU y accionesPas. Se han eliminado los modelos no utilizados.

    Modificado: En la vista ahora se utilizan las constantes para los personajes

    AÑADIR: Ahora mismo se muestran las habilidades pasivas desbloqueadas, mostrar también las habilidades de partido.
    Nota: en el listado, cada habilidad con un link a su descripción.

Usuarios.ver
    Modificado: En la vista ahora se utilizan las constantes para los personajes

    Modificado: Al hacer el render, se pasaban 2 variables cuando en la vista solo se utiliza modeloU. Se han eliminado los modelos no utilizados.

Usuarios.cuenta
    En la vista, los botones cambiarlos haciendo uso de la clase de Yii CHTML::Button.
    La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código)

Usuarios.cambiarClave
    En el modelo, revisar la expresion regular que valida las claves; una clave válida será:
    numeros o letras (mayusculas o minusculas) de 6 - 20 y aceptar "_"

Usuarios.cambiar email

###Equipos

Equipos.index
    En el controlador, al hacer la búsqueda del modelo, añadir un "order by" para que te los devuelva por orden de la posicion. Puedes suponer que no llegarán dos equipos con la misma posición.

Equipos.ver 
    Falta funcionalidad: para cualquier equipo mostrar la lista de jugadores que tiene ese equipo. En forma de tabla, el nombre del jugador (con enlace a su perfil de usuario), su nivel y el tipo de personaje que tiene.

    En la vista de tu propio equipo: cuando hay acciones grupales abiertas; se va a cambiar la vista por una tabla de acciones en la que no se va a imprimir el id, se imprimirá un link a la accion grupal (sobre el nombre de la accion abierta), el creador de la accion (con link a su perfil de jugador) y cuantos usuarios hay ya participando en esa accion.

    Falta el boton de cambiar de equipo. Para hacer el botón usar la clase de Yii CHTML::Button. 
    La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código) 

Equipos.cambiar [NO FUNCIONA]
    Modificado: Se ha eliminado la transacción. 

    Controlador: falta un save para guardar el nuevo registro. También falta un "if" que compruebe que no te estaas cambiando a tu propio equipo. 

    Modelo: hay que añadir "rules" para validar que el nuevo equipo al que cambias es un equipo existente en la base de datos (esta validación es en el modelo, la de que no te cambias a tu mismo equipo es en el controlador)

###Acciones

Acciones.index
    Controlador: Mostrar solo las habilidades grupales e individuales. (No las de partido ni las pasivas).

    Vista: Cambiar destinos del enlace y del botón; tiene que quedar que el nombre de la habilidad te lleva a ver la habilidad, y el botón (en el que pondrá usar habilidad) te lleva a usar la habilidad.

    Vista: Cambiar los botones haciendo uso de la clase de Yii CHTML::Button.
    La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código)

Acciones.usar [NO FUNCIONA]
    Controlador: Parece que están al revés los "if"

    Controlador: No hay que usar Yii::app()->user->id para coger el id del usuario sino
    Yii::app()->user->usIdent

    Controlador: no entendemos bien esto :S

    Vista: sin comprobar

Acciones.ver
    Faltan 2 comprobaciones.
    Controlador: comprobar que se pide mostrar una accion del quipo del usuario. (no se pueden ver acciones de otros equipos)

    Modelo: comprobar que se pide mostrar una accion grupal que existe. 

    Vista: Al mostrar la lista de usuarios participantes, mostrar el nombre del usuario, no el id del usuario (habrá que pasar esta información desde el controlador)

    Vista: Al mostrar la lista de usuarios participantes, no poner el botón de expulsar al propio creador de la accion.

Acciones.participar [POR COMPROBAR]
    Controlador: la transacción tiene que bloquear solo la tabla participaciones (que  no bloque la de habilidades, usuarios y participaciones)
    (colocar la linea de codigo justo antes de   
       $participacion = new Participaciones;)

    Nota: sin comprobar por no disponer del código actualizado.

Acciones.expulsar
    Controlador: falta la comprobacion de que no se está expulsando al propio jugador (que es el creador)

###Habilidades

Habilidades.index 
    Vista: Falta contemplar las habildiades pasivas y las de partido. Estamos mostrando el árbol completo. 

    Vista: Cambiar la información que se muestra en cada habilidad, mostrar el nombre (hecho), tipo de acción que es (la relación número - tipo está en constantes Habilidades::TIPO_N) y si está desbloqueada. No mostrar los recursos.

Habilidades.ver
    Vista: falta el botón para adquirir la habilidad. 
    hacer uso de la clase de Yii CHTML::Button.
    La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código)

    Vista: Faltan por contemplar las habilidades pasivas y las de partido

    Vista: Añadir a la información que se muestra toda la informacion que hay en la base de datos para acciones grupales.
    Nota: Las acciones no grupales, en esas columnas tienen NULL

    Modelo: comprobar que se pide mostrar una habilidad que existe.

Habilidades.adquirir