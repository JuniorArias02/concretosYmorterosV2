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

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gestionId = $_POST['gestion_id'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $archivo = $_FILES['archivo'] ?? null;

    // Verifica si los datos necesarios están presentes
    if ($gestionId && $nombre && $archivo) {
        // Verifica si el archivo se subió correctamente
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            // Obtiene la información del archivo
            $contenido = file_get_contents($archivo['tmp_name']);
            $nombreArchivo = $archivo['name'];
            $tipoMime = $archivo['type']; // Obtener el tipo MIME del archivo
            $fechaSubida = date('Y-m-d H:i:s');

            // Validar el tipo MIME (puedes agregar más tipos permitidos según sea necesario)
            $tiposPermitidos = [
                'application/msword',  
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',  
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',  
                'application/vnd.ms-powerpoint',  
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',  
                'image/jpeg',  
                'image/png'   
            ];
            
            if (!in_array($tipoMime, $tiposPermitidos)) {
                echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido.']);
                exit;
            }

            // Insertar el documento en la base de datos
            $consulta = $conexion->prepare("
                INSERT INTO documentos (id_gestion, nombre, contenido, mime_type, subido_por, fecha_subida) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $consulta->bind_param("isssis", $gestionId, $nombre, $contenido, $tipoMime, $userId, $fechaSubida);

            if ($consulta->execute()) {
                echo json_encode(['success' => true, 'message' => 'Documento subido con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar el documento en la base de datos.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
