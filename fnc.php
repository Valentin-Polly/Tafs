<?php   
    function conectarBaseDeDatos(){
     // Informacion de la base de datos para acceder
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "tafs";
 
     // Conectar con la base de datos con PHP MyAdmin
     // Se usa la palabra reservada "new para crear un nuevo objeto en base a una clase previamente creada (la clase es inherente al lenguaje asi no se ve programada).
     // Cada objeto creado suele tener funciones internas que no se pueden llamar por si solas o en objetos que no les correspondan.
     // Dichas funciones se llaman con: $NombreObjeto->NombreFuncion(), si la funcion no tiene un parentesis indica que es un atributo (una variable dentro del objeto).
     $conexion = new mysqli($servername, $username, $password, $dbname);
 
     // Antes de cualquier cosa, hay que corroborar la conexion con la base de datos
     if($conexion->connect_error){
        die("Connection failed: " . $conexion->connect_error);
     } else {
        return $conexion;
     }
    }

$conexion = conectarBaseDeDatos();

?>