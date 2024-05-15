<?php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Verifica que los campos no sean nulos
    if (!$email || !$password) {
        http_response_code(400);
        echo json_encode(["error" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Consulta la base de datos para verificar el correo electrónico y obtener el hash de la contraseña
    $query = "SELECT id, password_hash FROM usuarios WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Si no se encuentra el correo electrónico en la base de datos
        http_response_code(401);
        echo json_encode(["error" => "Correo electrónico o contraseña incorrectos"]);
        exit;
    }

    $usuario = $result->fetch_assoc();
    $usuario_id = $usuario['id'];
    $password_hash = $usuario['password_hash'];

    // Verifica la contraseña
    if (password_verify($password, $password_hash)) {
        // Inicio de sesión exitoso
        // Inicia la sesión y almacena el ID del usuario
        session_start();
        $_SESSION['usuario_id'] = $usuario_id;

        // Responde con éxito de inicio de sesión
        echo json_encode(["mensaje" => "Inicio de sesión exitoso"]);
    } else {
        // Contraseña incorrecta
        http_response_code(401);
        echo json_encode(["error" => "Correo electrónico o contraseña incorrectos"]);
    }

    // Cierra la declaración preparada
    $stmt->close();
}
?>
