<?php
include("../conexion/conexion.php");

header('Content-Type: application/json');
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
}

$userId = $_SESSION['user_id']; // Obtén el ID del usuario

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gestionId = $_POST['gestion_id'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $archivo = $_FILES['archivo'] ?? null;

    if ($gestionId && $nombre && $archivo) {
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            $contenido = file_get_contents($archivo['tmp_name']);
            $nombreArchivo = $archivo['name'];
            $tipoMime = $archivo['type']; // Obtener el tipo MIME del archivo
            $fechaSubida = date('Y-m-d H:i:s');

            // Validar el tipo MIME (puedes agregar más tipos permitidos según sea necesario)
            $tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!in_array($tipoMime, $tiposPermitidos)) {
                $response = ['success' => false, 'error' => 'Tipo de archivo no permitido.'];
                echo json_encode($response);
                exit;
            }

            // Insertar el documento en la base de datos
            $consulta = $conexion->prepare("
                INSERT INTO documentos (id_gestion, nombre, contenido, mime_type, subido_por, fecha_subida) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $consulta->bind_param("isssis", $gestionId, $nombre, $contenido, $tipoMime, $userId, $fechaSubida);

            if ($consulta->execute()) {
                $response = ['success' => true, 'message' => 'Documento subido con éxito'];
            } else {
                $response = ['success' => false, 'error' => $consulta->error];
            }
        } else {
            $response = ['success' => false, 'error' => 'Error al subir el archivo'];
        }
    } else {
        $response = ['success' => false, 'error' => 'Datos incompletos'];
    }
} else {
    $response = ['success' => false, 'error' => 'Método no permitido'];
}

echo json_encode($response);
?>
