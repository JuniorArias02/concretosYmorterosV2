<?php
include("../conexion/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDocumento = $_POST['id_documento'];

    try {
        $consulta = $conexion->prepare("
            DELETE FROM documentos 
            WHERE id = ?
        ");
        $consulta->bind_param("i", $idDocumento);
        $consulta->execute();

        echo json_encode(["success" => true, "message" => "Documento eliminado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
