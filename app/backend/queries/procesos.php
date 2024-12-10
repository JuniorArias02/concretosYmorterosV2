<?php
// Conexión a la base de datos
include '../conexion/conexion.php'; // Asegúrate de que la conexión se incluya correctamente

// Obtener el ID del proceso (puede venir de un parámetro GET)
$proceso_id = $_GET['proceso_id'];

// Consulta para obtener el nombre del proceso
$stmt = $conn->prepare("SELECT nombre FROM procesos WHERE id = :id");
$stmt->execute(['id' => $proceso_id]);
$proceso = $stmt->fetch(PDO::FETCH_ASSOC);

// Consulta para obtener las gestiones asociadas al proceso
$stmtGestiones = $conn->prepare("
    SELECT id AS gestion_id, tipo AS gestion_tipo 
    FROM gestiones 
    WHERE id_proceso = :id_proceso
");
$stmtGestiones->execute(['id_proceso' => $proceso_id]);
$gestiones = $stmtGestiones->fetchAll(PDO::FETCH_ASSOC);
?>
