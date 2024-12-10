<?php
include '../conexion/conexion.php'; // Asegúrate de que la conexión se incluya correctamente

$query = "SELECT id, nombre FROM procesos";
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta SQL: " . $conexion->error); // Muestra el error de la consulta
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a href="#" class="content_items_link" data-page="procesos_' . $row['id'] . '">' . $row['nombre'] . '</a>';
    }
} else {
    echo '<p>No hay procesos disponibles.</p>';
}
?>