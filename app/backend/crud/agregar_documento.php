<?php
include("../conexion/conexion.php");






// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $idGestion = $_POST['id_gestion'];
//     $nombreDocumento = $_POST['nombre_documento'];

//     try {
//         $consulta = $conexion->prepare("
//             INSERT INTO documentos (id_gestion, nombre) 
//             VALUES (?, ?)
//         ");
//         $consulta->bind_param("is", $idGestion, $nombreDocumento);
//         $consulta->execute();

//         echo json_encode(["success" => true, "message" => "Documento agregado correctamente."]);
//     } catch (Exception $e) {
//         echo json_encode(["success" => false, "message" => $e->getMessage()]);
//     }
// } else {
//     echo json_encode(["success" => false, "message" => "Método no permitido."]);
// }
?>
