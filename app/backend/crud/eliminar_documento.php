<?php
include("../conexion/conexion.php");
 
// Verificar si el parámetro 'documento_id' está presente
if (isset($_GET['documento_id'])) {
    $documentoId = $_GET['documento_id'];

    // Obtener el nombre del archivo para poder eliminarlo del servidor
    $consulta = $conexion->prepare("SELECT nombre, mime_type FROM documentos WHERE id = ?");
    $consulta->bind_param("i", $documentoId);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $documento = $resultado->fetch_assoc();
        $documentoNombre = $documento['nombre'];
        $mimeType = $documento['mime_type'];

        // Eliminar el documento de la base de datos
        $deleteQuery = $conexion->prepare("DELETE FROM documentos WHERE id = ?");
        $deleteQuery->bind_param("i", $documentoId);

        if ($deleteQuery->execute()) {
            // Eliminar el archivo físico si es necesario
            $filePath = "../../uploads/" . $documentoNombre;  // Ajusta el path donde guardas los archivos

            // Verificar si el archivo existe y eliminarlo
            if (file_exists($filePath)) {
                unlink($filePath);  // Elimina el archivo
            }

            echo json_encode(["success" => true, "message" => "Documento eliminado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el documento."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Documento no encontrado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID de documento no proporcionado."]);
}
?>
