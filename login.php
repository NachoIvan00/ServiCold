<?php
// Configura las cabeceras de la respuesta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Incluye la conexión a la base de datos
require_once 'conexion.php';

// Inicia la sesión
session_start();

// Lee los datos de la solicitud POST
$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos || !isset($datos['email']) || !isset($datos['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$email = $datos['email'];
$password = $datos['password'];

// Consulta la base de datos para verificar el correo electrónico y obtener el hash de la contraseña
$query = "SELECT id, password_hash, nombre, correo FROM usuarios WHERE email = ?";
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
$nombre = $usuario['nombre'];
$correo = $usuario['correo'];

// Verifica la contraseña
if (password_verify($password, $password_hash)) {
    // Inicio de sesión exitoso
    // Almacena la información del usuario en la sesión
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['correo'] = $correo;

    // Responde con éxito de inicio de sesión
    echo json_encode(["success" => true, "mensaje" => "Inicio de sesión exitoso"]);
} else {
    // Contraseña incorrecta
    http_response_code(401);
    echo json_encode(["error" => "Correo electrónico o contraseña incorrectos"]);
}

// Cierra la declaración preparada
$stmt->close();
$con->close();
?>
