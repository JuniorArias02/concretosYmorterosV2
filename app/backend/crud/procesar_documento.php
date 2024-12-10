<?php
include("../../backend/conexion/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $idGestion = $_POST['id_gestion'];
    $nombre = $_POST['nombre'];
    $subidoPor = $_POST['subido_por'];
    $fechaSubida = date('Y-m-d H:i:s'); // Fecha actual

    // Validar archivo subido
    if (isset($_FILES['contenido']) && $_FILES['contenido']['error'] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES['contenido']['tmp_name'];
        $contenido = file_get_contents($archivoTmp);

        try {
            // Insertar datos en la base de datos
            $consulta = $conexion->prepare("
                INSERT INTO documentos (id_gestion, nombre, contenido, subido_por, fecha_subida) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $consulta->bind_param("issis", $idGestion, $nombre, $contenido, $subidoPor, $fechaSubida);
            $consulta->execute();

            echo json_encode(["success" => true, "message" => "Documento agregado correctamente."]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error al subir el archivo."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
