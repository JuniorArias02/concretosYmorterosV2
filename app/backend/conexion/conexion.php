<?php
$servidor = "127.0.0.1";
$usuario = "root";
$contrasena = "root";
$base_datos = "concretoymorterosv2";
$puerto = "3306"; 

 
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos, $puerto);

 
if ($conexion->connect_error) {
    echo "<h1>Error en la conexión</h1>";
    echo "<p>Error: " . $conexion->connect_error . "</p>";
} else {
    // echo "<h1>Conexión exitosa a la base de datos</h1>";
}


if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
} else {
    // echo "Conexión exitosa";
}
 
?>
