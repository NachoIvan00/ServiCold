<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
    header("Location: login.html");
    exit;
}

// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID de usuario de la sesión
    $usuario_id = $_SESSION['usuario_id'];

    // Obtener la nueva contraseña del formulario
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';

    // Validar que la contraseña no esté vacía
    if (empty($nueva_contrasena)) {
        echo json_encode(["error" => "La contraseña no puede estar vacía"]);
        exit;
    }

    // Hashear la nueva contraseña
    $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

    // Actualizar la contraseña en la base de datos
    $stmt = $con->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?");
    $stmt->bind_param("si", $nueva_contrasena_hash, $usuario_id);
    $resultado = $stmt->execute();
    
    if ($resultado) {
        echo json_encode(["success" => "Contraseña actualizada con éxito"]);
    } else {
        echo json_encode(["error" => "Error al actualizar la contraseña"]);
    }

    // Cerrar la conexión y la declaración preparada
    $stmt->close();
    $con->close();
}
?>
