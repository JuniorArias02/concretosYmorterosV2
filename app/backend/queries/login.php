<?php
include("../conexion/conexion.php");

function validarInicioSesion($conexion, $documento, $password, $role) {
    $sql = "SELECT * FROM usuarios WHERE documento = ? AND contrasena = ? AND id_rol = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $documento, $password, $role); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        return $result->fetch_assoc(); 
    }
    return false; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? ''; 
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($username) || empty($password) || empty($role)) {
        die(json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]));
    }

    $user = validarInicioSesion($conexion, $username, $password, $role);
    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['id_rol'];
        $_SESSION['user_name'] = $user['nombre'];

        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso."]);
    } else {
        echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

$conexion->close();
?>
