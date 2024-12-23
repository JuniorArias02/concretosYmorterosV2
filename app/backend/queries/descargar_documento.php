<?php
include("../../backend/conexion/conexion.php");

// Verifica que se ha recibido el ID del documento
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Documento no encontrado.");
}

$documentoId = $_GET['id'];

// Consultar los datos del documento (nombre, contenido y tipo MIME)
$consulta = $conexion->prepare("
    SELECT nombre, contenido, mime_type 
    FROM documentos 
    WHERE id = ?
");
$consulta->bind_param("i", $documentoId);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows === 0) {
    die("Documento no encontrado.");
}

$documento = $resultado->fetch_assoc();
$nombreDocumento = $documento['nombre'];
$contenido = $documento['contenido'];
$mimeType = $documento['mime_type'];

// Configurar las cabeceras para la descarga del archivo
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $nombreDocumento . '"');
header('Content-Length: ' . strlen($contenido));

// Enviar el contenido del archivo al navegador
echo $contenido;
exit;
?>
