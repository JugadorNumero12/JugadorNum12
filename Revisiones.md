#REVISION 12 ENERO 2013

##Controladores

###Usuarios
1. Usuarios.index 	

2. Usuarios.perfil
    Cambiar el título de la página por 
    <h> perfil de nombre del usuario </h>

    No es necesaria la informacion de nick y email, los datos básicos se quedarán con el tipo de personaje, el nivel y el equipo exclusivamente

    Modificado: Al hacer el render, se pasan 4 variables cuando en la vista solo se utiliza modeloU y accionesPas. Se han eliminado los modelos no utilizados.

    Modificado: En la vista ahora se utilizan las constantes para los personajes
3. Usuarios.ver
    Modificado: En la vista ahora se utilizan las constantes para los personajes

    Modificado: Al hacer el render, se pasaban 2 variables cuando en la vista solo se utiliza modeloU. Se han eliminado los modelos no utilizados.

4. Usuarios.cuenta
    En la vista, los botones cambiarlos haciendo uso de la clase de Yii CHTML::Button. 
    La información de cómo hacerlo está en http://www.yiiframework.com/wiki/48/by-example-chtml/#hh1. (Hay un ejemplo que es copiar-pegar el código)

5. Usuarios.cambiarClave
    En el modelo, revisar la expresion regular que valida las claves; una clave válida será:
    numeros o letras (mayusculas o minusculas) de 6 - 20 y aceptar "_"

6. Usuarios.cambiar email