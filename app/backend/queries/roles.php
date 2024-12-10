<?php
 
include("../conexion/conexion.php");  

function getRoles($conexion) {
    $sql = "SELECT * FROM roles";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $roles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
    }
    return $roles;
}
